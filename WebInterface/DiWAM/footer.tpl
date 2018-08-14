<script>
$(document).ready(function(){

    get_json_data();
    setInterval(get_json_data,1000);
});

function get_json_data() {

    //make your ajax call here
    var admin_id = '<?php echo $_SESSION["admin_id"]; ?>';
    var url = "core/get_notif.php?admin_id="+admin_id;
    var data;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", url);
    xmlhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    xmlhttp.setRequestHeader("Access-Control-Allow-Origin", "*");
    xmlhttp.setRequestHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
    xmlhttp.setRequestHeader("Access-Control-Allow-Headers", "Content-Type");
    xmlhttp.setRequestHeader("Access-Control-Request-Headers", "X-Requested-With, accept, content-type");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            data = JSON.parse(xmlhttp.responseText);
            document.getElementById("notif_num").innerHTML = data.length;
        }
    };

    xmlhttp.send();
}
</script>