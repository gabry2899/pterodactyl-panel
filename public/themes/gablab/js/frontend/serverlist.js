(function updateServerStatus() {
    var Status = {
        500: {title: 'Error', class: 'text-danger'},
        504: {title: 'Gateway Error', class: 'text-danger'},
        0: {title: 'Offline', class: 'text-danger'},
        1: {title: 'Online', class: 'text-success'},
        2: {title: 'Starting', class: 'text-warning'},
        3: {title: 'Stopping', class: 'text-warning'},
        20: {title: 'Installing', class: 'text-warning'},
        30: {title: 'Suspended', class: 'text-warning'},
    };
    $('.dynamic-update').each(function (index, data) {
        var element = $(this);
        var serverShortUUID = $(this).data('server');

        function displayStatusLabel(status)
        {
            var $el = $("<i></i>")
            $el.addClass("far fa-dot-circle status");
            $el.addClass(Status[status].class);
            $el.attr("title", Status[status].title);
            element.find('[data-action="status"]').html($el);
            $el.tooltip({placement: 'right'});
        }

        function displayCpuUsage(data)
        {
            var cpuMax = element.data('cpumax');
            var currentCpu = data.total;
            if (cpuMax !== 0) {
                currentCpu = parseFloat(((data.total / cpuMax) * 100));
            }
            element.find('[data-action="cpu"]').html(currentCpu.toFixed(2).toString() + "%");
        }

        function displayMemoryUsage(data)
        {
            var memoryMax = element.data('memorymax');
            var totalMemory = data.total / (1024 * 1024);
            var currentMemory = parseFloat(totalMemory).toFixed(2) + " Mb";
            if (memoryMax !== 0) {
                currentMemory = parseFloat((totalMemory / memoryMax) * 100).toFixed(2) + "%";
            }
            element.find('[data-action="ram"]').html(currentMemory);
        }

        $.ajax({
            type: 'GET',
            url: Router.route('index.status', { server: serverShortUUID }),
            timeout: 5000,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
            }
        }).done(function (data) {
            if (typeof data.status === 'undefined') {
                return displayStatusLabel(500);}
                
            displayStatusLabel(data.status);
            
            if (data.status > 0 && data.status < 4) {
                displayCpuUsage(data.proc.cpu);
                displayMemoryUsage(data.proc.memory);
            } else if (data.status === 0) {
                element.find('[data-action="ram"]').html('--');
                element.find('[data-action="cpu"]').html('--');
            }
        }).fail(function (jqXHR) {
            displayStatusLabel(jqXHR.status !== 504 ? 500 : 504);
        });
    }).promise().done(function () {
        setTimeout(updateServerStatus, 10000);
    });
})();
