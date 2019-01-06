$(document).ready(function() {
    var $disk = $("[name='disk']");
    var $ram = $("[name='ram']");
    var $price_label = $("#price");
    function calculate_price()
    {
        var cost = $disk.val()*$disk.data('cost');
        cost += $ram.val()/1024*$ram.data('cost');
        $price_label.text(cost.toFixed(2));
    };
    function change_game()
    {
        var $this = $(this);
        var id = $this.data('id');
        
        location.href = "?egg="+id;
    };
    $(".game-card").on('click', change_game);
    $disk.on('change', calculate_price);
    $ram.on('change', calculate_price);
    calculate_price();
});