(function () {
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

    var i = 1;

    var table = document.querySelector('#table1 tbody');
    var table2 = document.querySelector('#table3 tbody');


    // var latestDateArray = [];
    var latestDate = '';

    const dbEvaluationStudentsRef = firebase.database().ref().child('users').child(userId).child('people');

    dbEvaluationStudentsRef.on('value', snapshot => {


        while (table.hasChildNodes()) {
            table.removeChild(table.firstChild);
        }

        // for notifications
        // var customKeys = $('#customkeys').val().split(',');
        // snapshot.forEach(function (child) {
        //
        //     var students1 = child.key;
        //
        //     const acb = firebase.database().ref().child('users').child(userId).child('people').child(students1).child('data');
        //     acb.on('value', snapshot1 => {
        //
        //         snapshot1.forEach(function (child) {
        //
        //             var sty = child.val();
        //             for (var key in sty) {
        //                 var sentence = sty[key].Message;
        //                 if(sty[key].failed === 1 && sty[key].checked != 1){  // for bot failure
        //                     $('#botFailNotify').show();
        //                 }else if(sty[key].checked != 1){
        //                     $.each(customKeys, function (index, value) {
        //                         if (!sentence.indexOf(value)) {
        //                             $('#'+value+'notify').show();
        //                         }
        //                     })
        //                 }
        //             }
        //         });
        //     });
        // });


        // for table content
        snapshot.forEach(function (child) {

            var students = child.key;

            var query = firebase.database().ref().child('users').child(userId).child('people').child(students).child('data').limitToLast(1);
            query.on("value", snapshot12 => {

                snapshot12.forEach(function (child) {

                    latestDate = child.key;
                    // var momentLastDate = moment(child.key, 'DD-MMM-YYYY').format('YYYY-MM-DD');
                    // var students12 = child.key;
                    //   latestDateArray.push(momentLastDate)
                });


            }, function (error) {
                console.log("Error: " + error.code);
            });

            const acb = firebase.database().ref().child('users').child(userId).child('people').child(students).child('details');
            acb.on('value', snapshot1 => {

                // latestDateArray.sort();


                // latestDate = latestDateArray[latestDateArray.length -1];

                var row = table.insertRow(-1);


                cell = row.insertCell(-1);
                var btn = document.createElement('input');
                cell.innerHTML = "";
                var link = document.createElement("a");

                link.setAttribute("href", "/user/view-user/" + students);

                link.className = "someCSSclass";

                var linkText = document.createTextNode(i);
                link.appendChild(linkText);
                cell.appendChild(link);


                cell = row.insertCell(-1);
                var btn = document.createElement('input');
                cell.innerHTML = "";
                var link = document.createElement("a");

                link.setAttribute("href", "/user/view-user/" + students);

                link.className = "someCSSclass";

                var linkText = document.createTextNode(latestDate);
                link.appendChild(linkText);
                cell.appendChild(link);


                snapshot1.forEach(function (child) {
                    var students1 = child.key;
                    var sty = child.val();


                    if (students1.includes('contactNumber')) {

                        var row1 = table2.insertRow(-1);
                        cell1 = row1.insertCell(-1);
                        cell1.innerHTML = "";
                        var link1 = document.createElement("a");
                        link1.className = "someCSSclass";
                        var linkText1 = document.createTextNode("");
                        link1.appendChild(linkText1);
                        cell1.appendChild(link1);

                        cell1 = row1.insertCell(-1);
                        cell1.innerHTML = "";
                        var link1 = document.createElement("a");
                        link1.className = "someCSSclass";
                        var linkText1 = document.createTextNode(sty);
                        link1.appendChild(linkText1);
                        cell1.appendChild(link1);


                        cell1 = row1.insertCell(-1);
                        cell1.innerHTML = "";
                        var link1 = document.createElement("a");
                        link1.className = "someCSSclass";
                        var linkText1 = document.createTextNode("");
                        link1.appendChild(linkText1);
                        cell1.appendChild(link1);

                    }


                    cell = row.insertCell(-1);
                    cell.innerHTML = "";
                    var link = document.createElement("a");
                    link.setAttribute("href", "/user/view-user/" + students);
                    link.className = "someCSSclass";

                    var linkText = document.createTextNode(sty);
                    link.appendChild(linkText);
                    cell.appendChild(link);
                });


                cell = row.insertCell(-1);
                var btn = document.createElement('input');
                btn.type = "button";
                btn.className = "btn";
                btn.value = "View Chat";
                btn.setAttribute("href", "/user/view-user/"+ students);
                btn.style.color = "white";
                btn.style.backgroundColor = "#2196f3";
                btn.onclick = (function (func) {
                    window.location = "/user/view-user/"+ students;
                });
                cell.appendChild(btn);


                i = i + 1;
            });

        });

    });

}());

 