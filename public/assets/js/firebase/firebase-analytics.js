
(function() {
    const config = {
        apiKey: "AIzaSyBMlB1hAA4xHWpfqlMoHxehf-6AyLSAnbU",
        authDomain: "flocklisten.firebaseapp.com",
        databaseURL: "https://flocklisten.firebaseio.com",
        projectId: "flocklisten",
        storageBucket: "flocklisten.appspot.com",
        messagingSenderId: "178649292360"
    };

    firebase.initializeApp(config);

    var userId = document.getElementById('userId').value;


    var urlRef = firebase.database().ref().child('users').child(userId).child('people');

    chartDiv(urlRef);

}());

// For chart 1 and chart 2

var previousChar2 = [];

function chartDiv(urlRef){
    var countArray = [];
    var messages = [];
    var date = moment().format('DD-MMM-YYYY');
    var currentDay = [];
    var lastDate = '';
    var startDate = '';
    urlRef.once('value').then(function(snapshot){
        snapshot.forEach(child => {

            var series = child.val().data;

            previousChar2.push(series);

            for (var key in series) {

                // checking for current date for chart 2
                // if(key.toString() === date.toString()){
                //     currentDay.push(series[key]);
                // }

                // for cahr 3
                messages.push(series[key]);

                // for cahrt 1
                var momentKey = moment(key, 'DD-MMM-YYYY').format('YYYY-MM-DD');
                if(countArray[momentKey]){
                    countArray[momentKey] = countArray[momentKey] + Object.keys(series[key]).length;
                }else{
                    countArray[momentKey] = Object.keys(series[key]).length;
                }
            }
        });

        // return [countArray,messages,currentDay];
        return [countArray,messages];
    }).then(function(string){

        // for chart 1
        chart(string[0]);

        // // for chart 2
        // chartDiv1(string[2]);

        preChart();
        // // for chart 3
        chartDiv2(string[1]);

    }).catch(function(error){
        console.log(error);
    });
}

function chart(chartData){

    var string = '[';
    var chat1Keys = Object.keys(chartData);
    chat1Keys.sort();

    for (var i = 0; i < chat1Keys.length; i++) {
        string += '{"date": "' + chat1Keys[i] + '","value": "' + chartData[chat1Keys[i]] + '"},';
    }

    // for (var key in chartData) {
    //     string += '{"date": "'+key+'","value": "'+chartData[key]+'"},';
    // }

    string = string.slice(0, -1);
    string = string+']';

    var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "light",
        "marginRight": 40,
        "marginLeft": 40,
        "autoMarginOffset": 20,
        "mouseWheelZoomEnabled": true,
        "dataDateFormat": "YYYY-MM-DD",
        "valueAxes": [{
            "id": "v1",
            "axisAlpha": 0,
            "position": "left",
            "ignoreAxisWidth": true
        }],
        "balloon": {
            "borderThickness": 1,
            "shadowAlpha": 0
        },
        "graphs": [{
            "id": "g1",
            "balloon": {
                "drop": true,
                "adjustBorderColor": false,
                "color": "#ffffff"
            },
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "bulletSize": 5,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "title": "red line",
            "useLineColorForBulletBorder": true,
            "valueField": "value",
            "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
        }],
        "chartScrollbar": {
            "graph": "g1",
            "oppositeAxis": false,
            "offset": 30,
            "scrollbarHeight": 80,
            "backgroundAlpha": 0,
            "selectedBackgroundAlpha": 0.1,
            "selectedBackgroundColor": "#888888",
            "graphFillAlpha": 0,
            "graphLineAlpha": 0.5,
            "selectedGraphFillAlpha": 0,
            "selectedGraphLineAlpha": 1,
            "autoGridCount": true,
            "color": "#AAAAAA"
        },
        "chartCursor": {
            "pan": true,
            "valueLineEnabled": true,
            "valueLineBalloonEnabled": true,
            "cursorAlpha": 1,
            "cursorColor": "#258cbb",
            "limitToGraph": "g1",
            "valueLineAlpha": 0.2,
            "valueZoomable": true
        },
        "valueScrollbar": {
            "oppositeAxis": false,
            "offset": 50,
            "scrollbarHeight": 10
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "dashLength": 1,
            "minorGridEnabled": true
        },
        "export": {
            "enabled": true
        },
        "dataProvider": JSON.parse(string)
    });

    chart.addListener("rendered", zoomChart);

    function zoomChart() {
        chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
    }
}

// for chart 2
function chartDiv1(data){

    var array= [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

    data.forEach((value, key)=>{
        for (var key1 in value) {
            var number  = parseInt(key1.split(":")[0]);
            if(array[number]){
                array[number] = array[number]+1;
            }else{
                array[number] = 1;
            }
        }
    });

    chart1(array);
}

function chart1(chartData){

    var string = '[';

    for (var key in chartData) {
        string += '{"hour": "'+key+'","visitors": '+chartData[key]+'},';
    }

    string = string.slice(0, -1);
    string = string+']';

    var chart = AmCharts.makeChart( "chartdiv1", {
        "type": "radar",
        "theme": "light",
        "dataProvider": JSON.parse(string),
        "valueAxes": [ {
            "axisTitleOffset": 20,
            "minimum": 0,
            "axisAlpha": 0.15
        } ],
        "startDuration": 2,
        "graphs": [ {
            "balloonText": "[[value]] visitors per hour",
            "bullet": "round",
            "lineThickness": 2,
            "valueField": "visitors"
        } ],
        "categoryField": "hour",
        "export": {
            "enabled": true
        }
    } );
}

// for chart 3
function chartDiv2(data){

    var messageCount={};
    var dayWise = [];
    data.forEach((value, key)=>{
        for (var key1 in value) {

            var message = value[key1].Message;
            message = message.replace(/(\r\n\t|\n|\r\t|\r|\t)/gm,"").replace(/ +(?= )/g,'');
            message.split(" ").forEach(function(el,i,arr){
                el= JSON.stringify(el).slice(1, -1);
                messageCount[el]=  messageCount[el]? ++messageCount[el]: 1;
            });
        }
    });

    chart2(messageCount);

}

function chart2(data){

    var string = '[';

    var color = ['#FF0F00', '#FF6600', '#FF9E01', '#FCD202', '#F8FF01', '#B0DE09', '#04D215','#0D8ECF', '#0D52D1', '#2A0CD0', '#8A0CCF', '#CD0D74']

    var wordsRemoved = ['The','A','And','This','That','If','In','Is','It','Are'];
    var sorted = Object.keys(data).sort((a, b) => data[b] - data[a]);
    sorted = sorted.filter(val => !wordsRemoved.includes(val)).slice(0, 19);
    sorted.forEach(x => string += '{"word": "'+x+'","count": '+data[x]+',"color": "'+color[Math.floor(Math.random()*color.length)]+'"},');

    string = string.slice(0, -1);
    string = string+']';

    var chart = AmCharts.makeChart("chartdiv2", {
        "type": "serial",
        "theme": "light",
        "marginRight": 70,
        "dataProvider": JSON.parse(string),
        "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": "Count per word"
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b>",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "count"
        }],
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
        },
        "categoryField": "word",
        "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
        },
        "export": {
            "enabled": true
        }

    });
}