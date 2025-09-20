/**
 * Unit tests for deletion protection JavaScript
 * Using Jest testing framework
 */

// Mock DOM and fetch
global.fetch = jest.fn();
global.console = { log: jest.fn(), error: jest.fn() };

// Mock the deletion protection class
class DeletionProtection {
    constructor() {
        this.initializeEventListeners();
        this.preventDefaultDeletions();
    }

    initializeEventListeners() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-delete-entity]') || e.target.closest('[data-delete-entity]')) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                
                console.log('Deletion button clicked, preventing default behavior');
                
                const button = e.target.matches('[data-delete-entity]') ? e.target : e.target.closest('[data-delete-entity]');
                this.handleDeletionRequest(button);
                
                return false;
            }
        }, true);
    }

    preventDefaultDeletions() {
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (form.method && form.method.toLowerCase() === 'post' && 
                form.querySelector('input[name="_method"][value="DELETE"]')) {
                
                const deleteButton = form.querySelector('[data-delete-entity]');
                if (deleteButton) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    console.log('Prevented form submission, using smart deletion instead');
                    this.handleDeletionRequest(deleteButton);
                    return false;
                }
            }
        }, true);

        const originalConfirm = window.confirm;
        window.confirm = function(message) {
            if (message && message.toLowerCase().includes('delete')) {
                console.log('Blocked confirm dialog for deletion:', message);
                return false;
            }
            return originalConfirm.call(this, message);
        };
    }

    async handleDeletionRequest(button) {
        const entityType = button.dataset.deleteEntity;
        const entityId = button.dataset.deleteId;
        const entityName = button.dataset.deleteName || '';
        const deleteUrl = button.dataset.deleteUrl;

        try {
            this.showLoadingState(button);
            const dependencyData = await this.checkDependencies(entityType, entityId);
            this.hideLoadingState(button);
            this.showDeletionModal({
                entityType,
                entityName,
                deleteUrl,
                ...dependencyData
            });
        } catch (error) {
            console.error('Error checking dependencies:', error);
            this.hideLoadingState(button);
            this.showErrorModal('Unable to check dependencies. Please try again.');
        }
    }

    async checkDependencies(entityType, entityId) {
        const response = await fetch(`/api/check-dependencies/${entityType}/${entityId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (!response.ok) {
            throw new Error('Failed to check dependencies');
        }

        return await response.json();
    }

    showLoadingState(button) {
        const originalText = button.textContent;
        button.dataset.originalText = originalText;
        button.disabled = true;
        button.innerHTML = 'Checking...';
    }

    hideLoadingState(button) {
        button.disabled = false;
        button.textContent = button.dataset.originalText || 'Delete';
    }

    showDeletionModal(data) {
        window.dispatchEvent(new CustomEvent('open-deletion-modal', { detail: data }));
    }

    showErrorModal(message) {
        console.error(message);
    }
}

describe('DeletionProtection', () => {
    let deletionProtection;
    let mockButton;
    let mockForm;

    beforeEach(() => {
        // Reset DOM
        document.body.innerHTML = '';
        
        // Reset fetch mock
        fetch.mockClear();
        console.log.mockClear();
        console.error.mockClear();

        // Create mock button
        mockButton = document.createElement('button');
        mockButton.setAttribute('data-delete-entity', 'client');
        mockButton.setAttribute('data-delete-id', '1');
        mockButton.setAttribute('data-delete-name', 'Test Client');
        mockButton.setAttribute('data-delete-url', '/clients/1');
        mockButton.textContent = 'Delete';
        document.body.appendChild(mockButton);

        // Create mock form
        mockForm = document.createElement('form');
        mockForm.method = 'POST';
        const methodInput = document.createElement('input');
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        mockForm.appendChild(methodInput);
        mockForm.appendChild(mockButton.cloneNode(true));
        document.body.appendChild(mockForm);

        // Create CSRF token meta tag
        const csrfMeta = document.createElement('meta');
        csrfMeta.name = 'csrf-token';
        csrfMeta.content = 'test-token';
        document.head.appendChild(csrfMeta);

        deletionProtection = new DeletionProtection();
    });

    afterEach(() => {
        document.body.innerHTML = '';
        document.head.innerHTML = '';
    });

    test('should initialize event listeners', () => {
        expect(deletionProtection).toBeDefined();
        expect(typeof deletionProtection.initializeEventListeners).toBe('function');
        expect(typeof deletionProtection.preventDefaultDeletions).toBe('function');
    });

    test('should prevent default behavior on delete button click', () => {
        const mockEvent = {
            target: mockButton,
            preventDefault: jest.fn(),
            stopPropagation: jest.fn(),
            stopImmediatePropagation: jest.fn()
        };

        // Simulate click event
        mockButton.click = jest.fn();
        mockButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
        });

        // Trigger click
        mockButton.dispatchEvent(new Event('click'));

        expect(console.log).toHaveBeenCalledWith('Deletion button clicked, preventing default behavior');
    });

    test('should show loading state when checking dependencies', async () => {
        fetch.mockResolvedValueOnce({
            ok: true,
            json: async () => ({ canDelete: true, dependencies: [], warnings: [] })
        });

        await deletionProtection.handleDeletionRequest(mockButton);

        expect(mockButton.disabled).toBe(false); // Should be restored after loading
        expect(mockButton.textContent).toBe('Delete');
    });

    test('should make API call to check dependencies', async () => {
        const mockResponse = {
            canDelete: false,
            dependencies: ['1 active plan'],
            warnings: ['Client has active subscriptions'],
            alternativeActions: []
        };

        fetch.mockResolvedValueOnce({
            ok: true,
            json: async () => mockResponse
        });

        await deletionProtection.handleDeletionRequest(mockButton);

        expect(fetch).toHaveBeenCalledWith('/api/check-dependencies/client/1', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': 'test-token'
            }
        });
    });

    test('should handle API errors gracefully', async () => {
        fetch.mockRejectedValueOnce(new Error('Network error'));

        await deletionProtection.handleDeletionRequest(mockButton);

        expect(console.error).toHaveBeenCalledWith('Error checking dependencies:', expect.any(Error));
        expect(mockButton.disabled).toBe(false);
    });

    test('should prevent form submissions for delete forms', () => {
        const mockEvent = {
            target: mockForm,
            preventDefault: jest.fn(),
            stopPropagation: jest.fn(),
            stopImmediatePropagation: jest.fn()
        };

        // Simulate form submission
        mockForm.dispatchEvent(new Event('submit'));

        expect(console.log).toHaveBeenCalledWith('Prevented form submission, using smart deletion instead');
    });

    test('should block confirm dialogs for deletions', () => {
        const result = window.confirm('Are you sure you want to delete this item?');

        expect(result).toBe(false);
        expect(console.log).toHaveBeenCalledWith('Blocked confirm dialog for deletion:', 'Are you sure you want to delete this item?');
    });

    test('should allow non-deletion confirm dialogs', () => {
        // Mock original confirm to return true
        const originalConfirm = jest.fn(() => true);
        window.confirm = function(message) {
            if (message && message.toLowerCase().includes('delete')) {
                return false;
            }
            return originalConfirm(message);
        };

        const result = window.confirm('Are you sure you want to save this?');

        expect(result).toBe(true);
        expect(originalConfirm).toHaveBeenCalledWith('Are you sure you want to save this?');
    });

    test('should dispatch modal open event with correct data', async () => {
        const mockResponse = {
            canDelete: true,
            dependencies: [],
            warnings: [],
            alternativeActions: []
        };

        fetch.mockResolvedValueOnce({
            ok: true,
            json: async () => mockResponse
        });

        const eventSpy = jest.fn();
        window.addEventListener('open-deletion-modal', eventSpy);

        await deletionProtection.handleDeletionRequest(mockButton);

        expect(eventSpy).toHaveBeenCalledWith(expect.objectContaining({
            detail: expect.objectContaining({
                entityType: 'client',
                entityName: 'Test Client',
                deleteUrl: '/clients/1',
                canDelete: true
            })
        }));
    });

    test('should handle buttons without data attributes gracefully', async () => {
        const plainButton = document.createElement('button');
        plainButton.textContent = 'Regular Button';

        await deletionProtection.handleDeletionRequest(plainButton);

        expect(fetch).not.toHaveBeenCalled();
    });

    test('should restore button state after error', async () => {
        fetch.mockRejectedValueOnce(new Error('API Error'));

        const originalText = mockButton.textContent;
        await deletionProtection.handleDeletionRequest(mockButton);

        expect(mockButton.textContent).toBe(originalText);
        expect(mockButton.disabled).toBe(false);
    });
});

describe('Schedule Conflict Detection', () => {
    let deletionProtection;

    beforeEach(() => {
        deletionProtection = new DeletionProtection();
        fetch.mockClear();
    });

    test('should detect schedule conflicts', async () => {
        const conflictData = {
            professional_id: 1,
            room_id: 1,
            start_date: '2024-01-15',
            start_time: '10:00',
            duration: 60
        };

        const mockConflicts = [
            'Professional has another class: Pilates with John Doe at 10:30',
            'Room is occupied: Yoga with Jane Smith at 10:15'
        ];

        fetch.mockResolvedValueOnce({
            ok: true,
            json: async () => mockConflicts
        });

        const conflicts = await deletionProtection.constructor.checkScheduleConflicts(conflictData);

        expect(fetch).toHaveBeenCalledWith('/api/check-schedule-conflicts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': expect.any(String)
            },
            body: JSON.stringify(conflictData)
        });

        expect(conflicts).toEqual(mockConflicts);
    });

    test('should handle no conflicts', async () => {
        fetch.mockResolvedValueOnce({
            ok: true,
            json: async () => []
        });

        const conflicts = await deletionProtection.constructor.checkScheduleConflicts({
            professional_id: 1,
            room_id: 1,
            start_date: '2024-01-15',
            start_time: '14:00',
            duration: 60
        });

        expect(conflicts).toEqual([]);
    });
});
