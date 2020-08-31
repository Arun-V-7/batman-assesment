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

    // for showing the count of subscribers , unsubscribers
    var clients = firebase.database().ref().child('users').child(userId).child('clients');

    clients.once("value", function (snapshot) {

        var subscribers = 0;
        var unSubscribers = 0;
        var totalUsers = 0;
        snapshot.forEach(function (child) {

            totalUsers += 1;

            if (child.val().status == 1) {
                subscribers += 1;
            } else if (child.val().status == 0) {
                unSubscribers += 1;
            }
        });

        $('#total').html(totalUsers);
        $('#subscribers').html(subscribers);
        $('#unsubscribers').html(unSubscribers);
    });

    //to show the messages previous history
    var messages = firebase.database().ref().child('users').child(userId).child('messages');
    var messageArray = [];
    var string = '';
    messages.once("value", function (snapshot) {
        snapshot.forEach(function (child) {

            var dayMessages = child.val();
            for (var key in dayMessages) {

                string += '<tr><td>' + dayMessages[key].message + '</td><td>' + child.key + '</td><td>' + key + '</td></tr>'

                // messageArray.push({date: child.key,
                //                     time: key,
                //                     message: dayMessages[key].message})
                // console.log(dayMessages[key].message);
            }
            // console.log(child.key+": "+child.val());
        });

        $('#example').append('<tbody>' + string + '</tbody>');
        $('#example').DataTable();

    });

}());

function globalPush(){

    var userId = document.getElementById('userId').value;
    var date = moment().format("DD-MMM-YYYY");
    var time = moment().format('HH:mm:ss');

    var message = $('#pushGMessage').val();
    var updateMessage = firebase.database().ref('users').child(userId);
    // var update = firebase.database().ref('users/' + userId + '/messages/' + date).child(time).set({message: message});

    var table = $('#example').DataTable();
    var row = $('<tr>')
        .append('<td>' + message + '</td>')
        .append('<td>' + date + '</td>')
        .append('<td>' + time + '</td>');

    table.row.add(row);
    $('#example tbody').prepend(row);

    updateMessage.update({
        currentMessage: message,
        click: 1
    });

    if (confirm('Successfully pushed')) {
        location.reload()
    }
    else {
    }
}

function specifiecPush(){

    var userId = document.getElementById('userId').value;
    var date = moment().format("DD-MMM-YYYY");
    var time = moment().format('HH:mm:ss');

    var message = $('#pushSMessage').val();
    var category = $('#category').val();
    var updateMessage = firebase.database().ref('users').child(userId);
    // var update = firebase.database().ref('users/' + userId + '/messages/' + date).child(time).set({message: message});

    var table = $('#example').DataTable();
    var row = $('<tr>')
        .append('<td>' + message + '</td>')
        .append('<td>' + date + '</td>')
        .append('<td>' + time + '</td>');

    table.row.add(row);
    $('#example tbody').prepend(row);

    updateMessage.update({
        currentCategory: category,
        currentMessage: message,
        click: 1
    });

    if (confirm('Successfully pushed')) {
        location.reload()
    }
    else {
    }
}