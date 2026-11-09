// TaxiDash In-Ride Navigation & Back-Button Protection
(function() {
    if (window.history && window.history.pushState) {
        window.history.pushState('ride_in_progress', null, window.location.href);
        window.addEventListener('popstate', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Active Ride in Progress',
                    html: '<p class="mb-2">You are currently in the middle of a ride.</p><p class="small text-muted mb-0">Going back will return you to your Dashboard. Don\'t worry, your ride is saved and can be resumed at any time.</p>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3bafda',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-home me-1"></i> Go to Dashboard',
                    cancelButtonText: '<i class="fas fa-arrow-left me-1"></i> Stay on Ride Screen',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'client-dashboard.php';
                    } else {
                        window.history.pushState('ride_in_progress', null, window.location.href);
                    }
                });
            } else {
                if (confirm('You have an active ride in progress. Do you want to return to Dashboard?')) {
                    window.location.href = 'client-dashboard.php';
                } else {
                    window.history.pushState('ride_in_progress', null, window.location.href);
                }
            }
        });
    }
})();
