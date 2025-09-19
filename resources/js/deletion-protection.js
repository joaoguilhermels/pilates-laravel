/**
 * Smart Deletion Protection System
 * Handles dependency checking and safe deletion workflows
 */

class DeletionProtection {
    constructor() {
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Handle deletion button clicks
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-delete-entity]') || e.target.closest('[data-delete-entity]')) {
                e.preventDefault();
                const button = e.target.matches('[data-delete-entity]') ? e.target : e.target.closest('[data-delete-entity]');
                this.handleDeletionRequest(button);
            }
        });
    }

    async handleDeletionRequest(button) {
        const entityType = button.dataset.deleteEntity;
        const entityId = button.dataset.deleteId;
        const entityName = button.dataset.deleteName || '';
        const deleteUrl = button.dataset.deleteUrl;

        try {
            // Show loading state
            this.showLoadingState(button);

            // Check dependencies
            const dependencyData = await this.checkDependencies(entityType, entityId);
            
            // Hide loading state
            this.hideLoadingState(button);

            // Show smart deletion modal
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
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (!response.ok) {
            throw new Error('Failed to check dependencies');
        }

        return await response.json();
    }

    showDeletionModal(data) {
        // Update modal content
        this.updateModalContent(data);
        
        // Dispatch event to open modal
        window.dispatchEvent(new CustomEvent('open-deletion-modal', { detail: data }));
    }

    updateModalContent(data) {
        // This would be handled by Alpine.js in the modal component
        // The data is passed through the custom event
    }

    showLoadingState(button) {
        const originalText = button.textContent;
        button.dataset.originalText = originalText;
        button.disabled = true;
        button.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Checking...
        `;
    }

    hideLoadingState(button) {
        button.disabled = false;
        button.textContent = button.dataset.originalText || 'Delete';
    }

    showErrorModal(message) {
        // Simple error notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50';
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    // Conflict detection for scheduling
    static async checkScheduleConflicts(data) {
        const response = await fetch('/api/check-schedule-conflicts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error('Failed to check schedule conflicts');
        }

        return await response.json();
    }

    // Schedule conflict notification
    static showConflictWarning(conflicts) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded z-50 max-w-md';
        
        let conflictList = conflicts.map(conflict => `• ${conflict}`).join('<br>');
        notification.innerHTML = `
            <strong>Schedule Conflicts Detected:</strong><br>
            ${conflictList}
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 8000);
    }
}

// Schedule conflict checking for forms
class ScheduleConflictChecker {
    constructor() {
        this.initializeFormListeners();
    }

    initializeFormListeners() {
        // Listen for changes in schedule forms
        const scheduleInputs = document.querySelectorAll('[data-schedule-input]');
        scheduleInputs.forEach(input => {
            input.addEventListener('change', this.debounce(() => {
                this.checkConflicts();
            }, 500));
        });
    }

    async checkConflicts() {
        const formData = this.gatherScheduleData();
        if (!this.isValidScheduleData(formData)) return;

        try {
            const conflicts = await DeletionProtection.checkScheduleConflicts(formData);
            if (conflicts.length > 0) {
                DeletionProtection.showConflictWarning(conflicts);
            }
        } catch (error) {
            console.error('Error checking schedule conflicts:', error);
        }
    }

    gatherScheduleData() {
        return {
            professional_id: document.querySelector('[name="professional_id"]')?.value,
            room_id: document.querySelector('[name="room_id"]')?.value,
            start_date: document.querySelector('[name="start_date"]')?.value,
            start_time: document.querySelector('[name="start_time"]')?.value,
            duration: document.querySelector('[name="duration"]')?.value || 60
        };
    }

    isValidScheduleData(data) {
        return data.professional_id && data.room_id && data.start_date && data.start_time;
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new DeletionProtection();
    new ScheduleConflictChecker();
});

export { DeletionProtection, ScheduleConflictChecker };
