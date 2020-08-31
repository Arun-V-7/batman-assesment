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

    var table = document.querySelector('#table1 tbody');

    const dbEvaluationStudentsRef = firebase.database().ref().child('users').child(userId).child('people');

    dbEvaluationStudentsRef.on('value', snapshot => {
        while (table.hasChildNodes()) {
            table.removeChild(table.firstChild);
        }

        var finalArray = [];
        snapshot.forEach(function (child) {

            var students = child.key;

            const acb = firebase.database().ref().child('users').child(userId).child('people').child(students).child('data');
            acb.on('value', snapshot1 => {

                snapshot1.forEach(function (child) {

                    var date = child.key;
                    var sty = child.val();

                    for (var key in sty) {
                        finalArray.push({
                            number: students,
                            dateTime: date+' '+key,
                            message : sty[key].Message
                        });
                    }

                });
            });
        });

        finalArray = _.sortBy(finalArray, 'dateTime').reverse();

        var i = 1;
        for (var key in finalArray) {

            var row = table.insertRow(-1);

            cell = row.insertCell(-1);
            var btn = document.createElement('input');
            cell.innerHTML = "";
            var link = document.createElement("a");

            link.setAttribute("href", "view-user.php?" + "number=" + finalArray[key].number);

            link.className = "someCSSclass";

            var linkText = document.createTextNode(i);
            link.appendChild(linkText);
            cell.appendChild(link);

            cell = row.insertCell(-1);
            var btn = document.createElement('input');
            cell.innerHTML = "";
            var link = document.createElement("a");

            link.setAttribute("href", "view-user.php?" + "number=" + finalArray[key].number);

            link.className = "someCSSclass";

            var linkText = document.createTextNode(finalArray[key].number);
            link.appendChild(linkText);
            cell.appendChild(link);


            cell = row.insertCell(-1);
            var btn = document.createElement('input');
            cell.innerHTML = "";
            var link = document.createElement("a");

            link.setAttribute("href", "view-user.php?" + "number=" + finalArray[key].number);

            link.className = "someCSSclass";

            var linkText = document.createTextNode(finalArray[key].dateTime);
            link.appendChild(linkText);
            cell.appendChild(link);


            cell = row.insertCell(-1);
            cell.innerHTML = "";
            var link = document.createElement("a");
            link.setAttribute("href", "view-user.php?" + "number=" + finalArray[key].number);
            link.className = "someCSSclass";
            var linkText = document.createTextNode(finalArray[key].message);
            link.appendChild(linkText);
            cell.appendChild(link);

            i = i + 1;
        }

    });
}());

