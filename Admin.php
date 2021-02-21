<?php
include('functions.php');
include('DBconnect.php');

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header("location: login.php");
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="adminScreen1.css" />
    <script src="https://cdn.anychart.com/js/8.0.1/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/js/8.0.1/anychart-pie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Create Dynamic Column Chart using PHP Ajax with Google Charts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.1/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.1/mapbox-gl.css" rel="stylesheet" />
    <script type="text/javascript" src="js/geojson.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>

    <div align="center" class="header">
        <div class="imgcontainer">
            <img src="leaf.jpg" alt="Avatar" class="avatar">
            <div class="welcome">
                .welcome
            </div>
        </div>
    </div>
</head>

<body>
    <div class="container">
        <div align="center" class="content">
            <div class="profinfo_wrap">
                <div class="profile_info">
                    <?php if (isset($_SESSION['user'])) : ?>
                        <strong><h4><?php echo  "Welcome, ", $_SESSION['user']['username']; ?></strong> <small><i style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</small></i></h4>
                       
                        <small>
                            
                            
                            <button type="button" class="btn1">
                                <a href="Admin.php?logout='1'">Logout</a>
                            </button>
                            &nbsp;
                           
                        </small>

                    <?php endif ?>
                </div>
            </div>

            <div class="navigation">
                <button class="btn5">
                    <a href="#" id="map">Απεικόνηση στοιχείων σε χάρτη</a>
                </button>
                <button class="btn5">
                    <a href="#" id="delete">Διαγραφή δεδομένων</a>
                </button>
                <button class="btn5">
                    <a href="#" id="export">Εξαγωγή δεδομένων</a>
                </button>
                <div class="dropdown">
                    <button class="btn6 dropdown-toggle" type="button" data-toggle="dropdown">Απεικόνηση
                        κατάστασης ΒΔ
                        <span class="caret"></span></button>
                    <div class="dropdown-content">
                        <ul>
                            <li><a href="#" id="graph1">Kατανομή των δραστηριοτήτων των χρηστών</a></li>
                            <li><a href="#" id="graph2">Kατανομή του πλήθους εγγραφών ανά χρήστη</a></li>
                            <li><a href="#" id="graph3">Kατανομή του πλήθους εγγραφών ανά μήνα </a></li>
                            <li><a href="#" id="graph4">Kατανομή του πλήθους εγγραφών ανά ημέρα της εβδομάδας </a></li>
                            <li><a href="#" id="graph5">Kατανομή του πλήθους εγγραφών ανά ώρα </a></li>
                            <li><a href="#" id="graph6">Kατανομή του πλήθους εγγραφών ανά έτος </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <script>
                function myFunction() {
                    var x = document.getElementById("demo");
                    if (x.className.indexOf("w3-show") == -1) {
                        x.className += " w3-show";
                    } else {
                        x.className = x.className.replace(" w3-show", "");
                    }
                }
            </script>

            <div class="content">
                <!-- notification message -->
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="error success">
                        <h3>
                            <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </h3>
                    </div>
                <?php endif ?>

                <!-- logged in user information -->
            </div>
        </div>


        <div id="displays" class="panel-body">
            <div class="scorewrap">
                <canvas id="bar-chart" style="width: 1000px; height: 500px;"></canvas>
            </div>
        </div>
        <div class="mapwrap">
            <div id="mapid"></div>
        </div>
    </div>
    </div>
    </div>
    <script>
        $('#delete').click(function() {
            if (confirm('Θέλετε σίγουρα να διάγραψετε τα δεδομένα της βάσης δεδομένων?')) {
                $.ajax({
                    url: 'emptyDB.php',
                    success: function(output) {
                        window.location.href = "http://localhost/project/register.php";
                    }
                });
            } else {
                ;
            }
        });
    </script>
    <script>
        $('body').click(function() {
            var log = $('#log');
            var title;
            var urls;
            var choice = 3;
            if ($(event.target).is('#graph1') || $(event.target).is('#graph2') || $(event.target).is('#graph3') ||
                $(event.target).is('#graph4') || $(event.target).is('#graph5') || $(event.target).is('#graph6')) {
                $('#chart_area').remove();
                $('#displays').append('<div id="chart_area">');
                $('#bar-chart').remove();
                $('#mapid').remove();
                $('#chart_area').append('<canvas id="bar-chart"><canvas>');
                if ($(event.target).is('#graph1')) {
                    title = "Κατανομή των δραστηριοτήτων των χρηστών % ";
                    urls = 'getJSONquery.php?QN=1';
                }
                if ($(event.target).is('#graph2')) {
                    title = "Κατανομή του πλήθους εγγραφών ανά χρήστη";
                    urls = 'getJSONquery.php?QN=2';
                }
                if ($(event.target).is('#graph3')) {
                    title = "Κατανομή του πλήθους εγγραφών ανά μήνα ";
                    urls = 'getJSONquery.php?QN=3';
                    choice = 1;
                }
                if ($(event.target).is('#graph4')) {
                    title = "Κατανομή του πλήθους εγγραφών ανά ημέρα της εβδομάδας";
                    urls = 'getJSONquery.php?QN=4';
                    choice = 2;
                }
                if ($(event.target).is('#graph5')) {
                    title = "Κατανομή του πλήθους εγγραφών ανά ώρα";
                    urls = 'getJSONquery.php?QN=5';
                }
                if ($(event.target).is('#graph6')) {
                    title = "Κατανομή του πλήθους εγγραφών ανά έτος";
                    urls = 'getJSONquery.php?QN=6';
                }
                $.ajax({
                    url: urls,
                    success: function(data) {
                        const obj = JSON.parse(data);
                        console.log(obj);
                        var x = [];
                        var value = [];
                        var colour = [];
                        var mychart;
                        for (var i in obj) {
                            x.push(obj[i].x);
                            if (obj[i].x == 1 && choice == 2) {
                                x[i] = "Δευτέρα";
                            }
                            if (obj[i].x == 2 && choice == 2) {
                                x[i] = "Τρίτη";
                            }
                            if (obj[i].x == 3 && choice == 2) {
                                x[i] = "Τετάρτη";
                            }
                            if (obj[i].x == 4 && choice == 2) {
                                x[i] = "Πέμπτη";
                            }
                            if (obj[i].x == 5 && choice == 2) {
                                x[i] = "Παρασκευή";
                            }
                            if (obj[i].x == 6 && choice == 2) {
                                x[i] = "Σάββατο";
                            }
                            if (obj[i].x == 7 && choice == 2) {
                                x[i] = "Κυριακή";
                            }
                            if (obj[i].x == 1 && choice == 1) {
                                x[i] = "Ιανουάριος"
                            }
                            if (obj[i].x == 2 && choice == 1) {
                                x[i] = "Φλεβάρης"
                            }
                            if (obj[i].x == 3 && choice == 1) {
                                x[i] = "Μάρτης"
                            }
                            if (obj[i].x == 4 && choice == 1) {
                                x[i] = "Απρίλης"
                            }
                            if (obj[i].x == 5 && choice == 1) {
                                x[i] = "Μάιος"
                            }
                            if (obj[i].x == 6 && choice == 1) {
                                x[i] = "Ιούνιος"
                            }
                            if (obj[i].x == 7 && choice == 1) {
                                x[i] = "Ιούλιος"
                            }
                            if (obj[i].x == 8 && choice == 1) {
                                x[i] = "Άυγουστος"
                            }
                            if (obj[i].x == 9 && choice == 1) {
                                x[i] = "Σεπτέμβριος"
                            }
                            if (obj[i].x == 10 && choice == 1) {
                                x[i] = "Οκτώβριος"
                            }
                            if (obj[i].x == 11 && choice == 1) {
                                x[i] = "Νοέμβριος"
                            }
                            if (obj[i].x == 12 && choice == 1) {
                                x[i] = "Δεκέμβριος"
                            }
                            value.push(obj[i].value);
                            var letters = '0123456789ABCDEF';
                            var color = '#';
                            for (var i = 0; i < 6; i++) {
                                color += letters[Math.floor(Math.random() * 16)];

                            }
                            colour.push(color);
                        }
                        mychart = new Chart(document.getElementById("bar-chart"), {
                            type: 'bar',
                            data: {
                                labels: x,
                                datasets: [{
                                    label: [title],
                                    backgroundColor: colour,
                                    data: value
                                }]
                            },
                            options: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: [title]
                                }
                            }
                        });
                    }
                });
            }
        });
    </script>
    <script>
        $('body').click(function() {
            var log = $('#log');
            if ($(event.target).is('#map')) {
                $('#chart_area').remove();
                $('#displays').append('<div id="chart_area">');
                $('#bar-chart').remove();
                
                $.ajax({

                    url: 'form.php',
                    success: function(html) {
                        $("#chart_area").append(html);
                    }
                });
                $('#chart_area').append('<div id="mapid"></div>');
                mapboxgl.accessToken =
                    'pk.eyJ1Ijoib3JpZ2FudGFzIiwiYSI6ImNrNGUwM3VpajA3dXYzdG8yMnZqZDhuNGMifQ.tjLUyCqoGt2IA5dtrctG5Q';
                var map = new mapboxgl.Map({
                    container: 'mapid', // container id
                    style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
                    center: [21.753150, 38.230462], // starting position [lng, lat]
                    zoom: 13 // starting zoom
                });
                $('#chart_area').on('click', '#search', (function() {
                    var act1 = document.getElementById("act1").value;
                    var act2 = document.getElementById("act2").value;
                    var year1 = document.getElementById("year1").value;
                    var year2 = document.getElementById("year2").value;
                    var time1 = document.getElementById("time1").value;
                    var time2 = document.getElementById("time2").value;
                    var month1 = document.getElementById("month1").value;
                    var month2 = document.getElementById("month2").value;
                    var day1 = document.getElementById("day1").value;
                    var day2 = document.getElementById("day2").value;
                    $.ajax({
                        url: 'getJSONquery.php?QN=7&val=' + act1 + '&val1=' + act2 + '&val2=' +
                            year1 + '&val3=' + year2 + '&val4=' + month1 + '&val5=' + month2 +
                            '&val6=' + time1 + '&val7=' + time2 + '&val8=' + day1 + '&val9=' +
                            day2,
                        success: function(data) {
                            var nameValue = document.getElementById("act1").value;
                            const obj = JSON.parse(data);
                            console.log(obj);
                            var geojson = {};
                            geojson['type'] = 'FeatureCollection';
                            geojson['features'] = [];
                            for (var i in obj) {
                                var newFeature = {
                                    "type": "Feature",
                                    "geometry": {
                                        "type": "Point",
                                        "coordinates": [parseFloat(obj[i].lon),
                                            parseFloat(obj[i].lat)
                                        ]
                                    },
                                    "properties": null
                                }
                                geojson['features'].push(newFeature);
                            }

                            mapboxgl.accessToken =
                                'pk.eyJ1Ijoib3JpZ2FudGFzIiwiYSI6ImNrNGUwM3VpajA3dXYzdG8yMnZqZDhuNGMifQ.tjLUyCqoGt2IA5dtrctG5Q';
                            var map = new mapboxgl.Map({
                                container: 'mapid', // container id
                                style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
                                center: [21.753150,
                                    38.230462
                                ], 
                                zoom: 13 // starting zoom
                            });
                            map.on('load', function() {
                               
                                map.addSource('heatmap', {
                                    'type': 'geojson',
                                    'data': geojson
                                });

                                map.addLayer({
                                    "id": "heatmap",
                                    "type": "heatmap",
                                    "source": "heatmap",
                                    "paint": {
                                        "heatmap-radius": 13,
                                        "heatmap-weight": {
                                            "stops": [
                                                [0, 0.5],
                                                [4, 2]
                                            ]
                                        },
                                        "heatmap-intensity": 0.7,
                                        "heatmap-color": [
                                            "interpolate",
                                            ["linear"],
                                            ["heatmap-density"],
                                            0, "rgba(0, 0, 255, 0)",
                                            0.1, "royalblue",
                                            0.3, "cyan",
                                            0.5, "lime",
                                            0.7, "yellow",
                                            1, "rgb(178,24,43)"
                                        ]
                                    }
                                }, 'waterway-label');

                            });
                        }
                    });

                }));
            }
        });
    </script>
    <script>
        $('body').click(function() {
            var log = $('#log');
            if ($(event.target).is('#export')) {
                $('#chart_area').remove();
                $('#displays').append('<div id="chart_area" >');
                $('#bar-chart').remove();
                $.ajax({

                    url: 'form2.php',
                    success: function(html) {
                        $("#chart_area").append(html);
                    }
                });
                $('#chart_area').on('click', '#download', (function() {
                    var act1 = document.getElementById("act1").value;
                    var act2 = document.getElementById("act2").value;
                    var year1 = document.getElementById("year1").value;
                    var year2 = document.getElementById("year2").value;
                    var time1 = document.getElementById("time1").value;
                    var time2 = document.getElementById("time2").value;
                    var month1 = document.getElementById("month1").value;
                    var month2 = document.getElementById("month2").value;
                    var day1 = document.getElementById("day1").value;
                    var day2 = document.getElementById("day2").value;
                    var type = document.getElementById("type").value;
                    $.ajax({
                        url: 'getJSONquery.php?QN=8&val=' + act1 + '&val1=' + act2 + '&val2=' +
                            year1 + '&val3=' + year2 + '&val4=' + month1 + '&val5=' + month2 +
                            '&val6=' + time1 + '&val7=' + time2 + '&val8=' + day1 + '&val9=' +
                            day2 + '&val10=' + type,
                        success: function(data) {
                            const obj = JSON.parse(data);
                            console.log(obj);

                            function downloadTextFile(text, name, int) {
                                const a = document.createElement('a');
                                const type = name.split(".").pop();
                                a.href = URL.createObjectURL(new Blob([text], {
                                    type: `text/${type === "txt" ? "plain" : type}`
                                }));
                                if(int==2){
                                name="data.xml";}
                                a.download = name;
                                a.click();
                            }

                            function OBJtoXML(obj) {
                                var xml = '';
                                // xml += "<Record>";
                                for (var prop in obj) {
                                    if (prop =='lat'){xml += "<Record>";}
                                    xml += obj[prop] instanceof Array ? '' : "<" + prop +
                                        ">";
                                    if (obj[prop] instanceof Array) {
                                        for (var array in obj[prop]) {
                                            xml += "<" + prop + ">";
                                            xml += OBJtoXML(new Object(obj[prop][array]));
                                            xml += "</" + prop + ">";
                                        }
                                    } else if (typeof obj[prop] == "object") {
                                        xml += OBJtoXML(new Object(obj[prop]));
                                    } else {
                                        xml += obj[prop];
                                    }
                                    xml += obj[prop] instanceof Array ? '' : "</" + prop +
                                        ">";
                                    if (prop =='username'){xml += "</Record>";}
                                }
                                var xml = xml.replace(/<\/?[0-9]{1,}>/g, '');
                                return xml;
                            }

                            if (type == 'json') {
                                downloadTextFile(JSON.stringify(obj), 'data.json',1);
                            } else if (type == 'xml') {
                                var element='';
                                element += "<?xml version='1.0'?>";
                                element += "<Records>";
                                element += OBJtoXML(obj);
                                element += "</Records>";
                                downloadTextFile(element, 'data',2);

                            } else {
                                var customers=JSON.stringify(obj);
                                var table = document.createElement("TABLE");
                                table.border = "1";
                                table.Id = "tblCustomers";
                        
                                var columnCount = customers[0].length;
                        
                                var row = table.insertRow(-1);
                                for (var i = 0; i < columnCount; i++) {
                                    var headerCell = document.createElement("TH");
                                    headerCell.innerHTML = customers[0][i];
                                    row.appendChild(headerCell);
                                }
                                for (var i = 1; i < customers.length; i++) {
                                    row = table.insertRow(-1);
                                    for (var j = 0; j < columnCount; j++) {
                                        var cell = row.insertCell(-1);
                                        cell.innerHTML = customers[i][j];
                                    }
                                }
                        
                                var dvTable = document.getElementById("dvTable");
                                dvTable.innerHTML = "";
                                dvTable.appendChild(table);
                        

                                html2canvas(document.getElementById('dvTable'), {
                                    onrendered: function (canvas) {
                                        var data = canvas.toDataURL();
                                        var docDefinition = {
                                            content: [{
                                                image: data,
                                                width: 500
                                            }]
                                        };
                                        pdfMake.createPdf(docDefinition).download("data.pdf");
                    
                                       dvTable.innerHTML = "";
                                    }
                                });
                               
                            }

                        }
                    });
                }));
            }
        });
    </script>
    <footer class="footer">
        Tsagketas Oresths, AM 6238 |
        Varvarigos Georgios, AM 5999 |
        Georgakopoulos Georgios, AM 6014 .
    </footer>
</body>

</html>