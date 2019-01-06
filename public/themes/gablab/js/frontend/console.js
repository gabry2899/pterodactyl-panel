var CONSOLE_PUSH_COUNT = Pterodactyl.config.console_count || 50;
var CONSOLE_PUSH_FREQ = Pterodactyl.config.console_freq || 200;
var CONSOLE_OUTPUT_LIMIT = Pterodactyl.config.console_limit || 2000;

var AnsiUp = new AnsiUp;

$(document).ready(function () {
    
    function commandListener(command)
    {
        if (command[0] == "@") {
            Socket.emit('set status', command.substring(1));
        } else {
            Socket.emit('send command', command);
        }
    };

    function updateServerProc(proc)
    {
        var cpuUse = (Pterodactyl.server.cpu > 0) ? parseFloat(((proc.data.cpu.total / Pterodactyl.server.cpu) * 100).toFixed(2).toString()) : proc.data.cpu.total;
        var memoryUse = parseInt(proc.data.memory.total / (1024 * 1024));
        $("[data-action='cpu']").text(cpuUse);
        $("[data-action='memory']").text(memoryUse);
    };

    function printToTerminal(line)
    {
        if (typeof line === 'object') {
            for (var i in line) printToTerminal(line[i]);
            return;
        }
        var html = AnsiUp.ansi_to_html(line + '\u001b[0m');
        term.echo(html, {raw: true, wrap: true, keepWords: false});
    };

    function updateServerPowerControls (data) {
        if(data == 1 || data == 2) {
            $('[data-attr="power"][data-action="start"]').addClass('disabled');
            $('[data-attr="power"][data-action="stop"], [data-attr="power"][data-action="restart"]').removeClass('disabled');
        } else {
            if (data == 0) {
                $('[data-attr="power"][data-action="start"]').removeClass('disabled');
            }
            $('[data-attr="power"][data-action="stop"], [data-attr="power"][data-action="restart"]').addClass('disabled');
        }

        if(data !== 0) {
            $('[data-attr="power"][data-action="kill"]').removeClass('disabled');
        } else {
            $('[data-attr="power"][data-action="kill"]').addClass('disabled');
        }
    };

    var term = $('#terminal').terminal(commandListener, {
        greetings: false,
        prompt: '$>'
    });

    Socket.on('server log', function(data) {
        if (data) printToTerminal(data.split("\n"))
    });

    Socket.on('console', function(data) {
        printToTerminal(data.line.split("\n"));
    });

    Socket.on('initial status', function (data) {
        updateServerPowerControls(data.status);

        if (data.status === 1 || data.status === 2) {
            Socket.emit('send server log');
        }
    });

    Socket.on('status', function (data) {
        updateServerPowerControls(data.status);
    });

    if (typeof fullScreen == 'undefined') {
        Socket.on('proc', updateServerProc);
    }

    $('[data-attr="power"]').click(function (event) {
        if (! $(this).hasClass('disabled')) {
            Socket.emit('set status', $(this).data('action'));
        }
    });

});