<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('assets') }}/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('assets') }}/vendor/js/bootstrap.js"></script>
<script src="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="{{ asset('assets') }}/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets') }}/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="{{ asset('assets') }}/js/main.js"></script>

<!-- Page JS -->
<script src="{{ asset('assets') }}/js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script>
    let toggle = document.getElementById('repeatToggle');
    let field = document.getElementById('repeatField');
    toggle.addEventListener('change', function() {

        if (this.checked) {
            field.style.display = 'block';
        } else {
            field.style.display = 'none';
        }
    });
</script>
@yield('script-ajax-search')
<script>
    const typeConfig = {
        order: {
            color: '#fff3cd',
            border: '#ffc107',
            icon: '🛒',
            label: 'New Order'
        },
        booking: {
            color: '#d1ecf1',
            border: '#17a2b8',
            icon: '📅',
            label: 'New Booking'
        },
        stock: {
            color: '#f8d7da',
            border: '#dc3545',
            icon: '💊',
            label: 'Low Stock'
        }
    };

    function loadNotifications() {
        $.ajax({
            url: "{{ route('notifications.get') }}",
            type: "GET",
            success: function(response) {
                $('#notif-count').text(response.count > 0 ? response.count : '').toggle(response.count > 0);
                if (response.count > 0) {
                    $('#notif-count').text(response.count).show();
                } else {
                    $('#notif-count').hide();
                }
                let list = '';
                if (response.data.length === 0) {
                    list = `<li class="dropdown-item text-center text-muted">No notifications</li>`;
                } else {
                    response.data.forEach(function(item) {
                        const config = typeConfig[item.type];
                        const readStyle = item.is_read ? 'opacity: 0.6;' : '';
                        list += `
                        <li class="dropdown-item notif-item"
                            data-id="${item.id}"
                            data-type="${item.type}"
                            style="
                                background: ${config.color};
                                border-right: 4px solid ${config.border};
                                ${readStyle}
                                cursor: pointer;
                                padding: 10px 15px;
                                margin-bottom: 4px;
                                border-radius: 6px;
                                transition: opacity 0.3s, background 0.3s;
                                min-width: 280px;
                                max-width: 350px;
                                white-space: normal;
                                word-break: break-word;
                            ">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>
                                    ${config.icon}
                                    <strong>${config.label}</strong>
                                </span>
                                <small class="text-muted">${item.time}</small>
                            </div>
                            <div class="mt-1" style="font-size:13px; margin-top:5px; color:#444; text-align:left; overflow-wrap: break-word;">
                                ${item.message}
                            </div>
                        </li>
                    `;
                    });
                }
                $('#notif-list').html(list);
            }
        });
    }
    loadNotifications();
    setInterval(loadNotifications, 5000);
</script>
<script>
    $(document).on('click', '.notif-item', function() {
        let id = $(this).data('id');
        let $item = $(this);

        $.ajax({
            url: "{{ route('notifications.markAsRead') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                $item.css('background', '');
                let currentCount = parseInt($('#notif-count').text()) || 0;
                if (currentCount > 0) {
                    $('#notif-count').text(currentCount - 1);
                }
            }
        });
    });
</script>
