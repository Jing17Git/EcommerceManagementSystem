let currentAction = null;

// Toggle table selection visibility
document.querySelectorAll('input[name="scope"]').forEach(radio => {
    radio.addEventListener('change', (e) => {
        const tableSelection = document.getElementById('tableSelection');
        tableSelection.style.display = e.target.value === 'selected' ? 'block' : 'none';
    });
});

// Show export confirmation
function showExportConfirm() {
    const scope = document.querySelector('input[name="scope"]:checked').value;
    const format = document.getElementById('exportFormat').value;
    
    let message = `Are you sure you want to export the ${scope === 'full' ? 'entire database' : 'selected tables'} in ${format.toUpperCase()} format?`;
    
    if (scope === 'selected') {
        const selectedTables = Array.from(document.querySelectorAll('#tableSelection input:checked'))
            .map(cb => cb.value);
        
        if (selectedTables.length === 0) {
            showAlert('Please select at least one table to export.', 'error');
            return;
        }
        
        message += `\n\nTables: ${selectedTables.join(', ')}`;
    }
    
    currentAction = 'export';
    showModal('Confirm Database Export', message);
}

// Show cache clear confirmation
function showCacheConfirm() {
    currentAction = 'cache';
    showModal(
        'Confirm Cache Clear',
        'Are you sure you want to clear all cached data? This action will temporarily affect system performance until the cache is rebuilt.'
    );
}

// Show modal
function showModal(title, message) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('modal').classList.add('show');
}

// Close modal
function closeModal() {
    document.getElementById('modal').classList.remove('show');
    currentAction = null;
}

// Confirm action
function confirmAction() {
    if (currentAction === 'export') {
        exportDatabase();
    } else if (currentAction === 'cache') {
        clearCache();
    }
    closeModal();
}

// Export database
function exportDatabase() {
    const scope = document.querySelector('input[name="scope"]:checked').value;
    const format = document.getElementById('exportFormat').value;
    
    // Simulate export process
    showAlert('Exporting database... Please wait.', 'success');
    
    setTimeout(() => {
        const filename = `database_backup_${new Date().toISOString().split('T')[0]}.${format}`;
        showAlert(`✓ Database exported successfully as ${filename}`, 'success');
        
        // In real implementation, trigger actual download
        // window.location.href = `/admin/export?format=${format}&scope=${scope}`;
    }, 1500);
}

// Clear cache
function clearCache() {
    showAlert('Clearing cache... Please wait.', 'success');
    
    setTimeout(() => {
        showAlert('✓ Cache cleared successfully! System performance optimized.', 'success');
        
        // Update cache info
        document.querySelector('.cache-info .value').textContent = '0 MB';
        document.querySelectorAll('.cache-info .value')[1].textContent = 'Just now';
        
        // In real implementation, make API call
        // fetch('/admin/clear-cache', { method: 'POST' });
    }, 1500);
}

// Show alert
function showAlert(message, type) {
    const alert = document.getElementById('alert');
    alert.textContent = message;
    alert.className = `alert ${type}`;
    alert.style.display = 'flex';
    
    setTimeout(() => {
        alert.style.display = 'none';
    }, 5000);
}

// Close modal on outside click
document.getElementById('modal').addEventListener('click', (e) => {
    if (e.target.id === 'modal') {
        closeModal();
    }
});
