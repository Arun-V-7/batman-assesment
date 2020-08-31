const config = {
  apiKey: "AIzaSyBMlB1hAA4xHWpfqlMoHxehf-6AyLSAnbU",
  authDomain: "flocklisten.firebaseapp.com",
  databaseURL: "https://flocklisten.firebaseio.com",
  projectId: "flocklisten",
  storageBucket: "flocklisten.appspot.com",
  messagingSenderId: "178649292360"
};

firebase.initializeApp(config);

  function myFunction() {
    var userId = document.getElementById('cust_word').value;

    var idoftheUser = document.getElementById('idoftheUser').value;

    var table = document.querySelector('#table2 tbody');
    var table2 = document.querySelector('#table3 tbody');

    //document.getElementById("#table2").remove();

    //table.remove();
    
    const dbEvaluationStudentsRef = firebase.database().ref().child('users').child(idoftheUser).child('people');
    dbEvaluationStudentsRef.on('value', snapshot => {
      
      while(table.hasChildNodes()) {
        table.removeChild(table.firstChild);
          }

        //var row = table.insertRow(-1);
        snapshot.forEach(function(child) {
            var number = child.key;
            
            var row = table.insertRow(-1);

            console.log("CHILD 1   "+number);
            const acb = firebase.database().ref().child('users').child(idoftheUser).child('people').child(number).child('data');
            acb.on('value', snapshot1 => {
              
                snapshot1.forEach(function(child) {
                    var date = child.key;
                    console.log('child 2 '+date); 
                    
                    const timeData = firebase.database().ref().child('users').child(idoftheUser).child('people').child(number).child('data').child(date);
                    timeData.on('value', snapshot2 => {
            
                    snapshot2.forEach(function(child) {
                    var time = child.key;
                    console.log('child 3 '+time); 
                    
                    const msgData = firebase.database().ref().child('users').child(idoftheUser).child('people').child(number).child('data').child(date).child(time);
                    msgData.on('value', snapshot3 => {
            
                    snapshot3.forEach(function(child) {
                    
                    var msg = child.val();
                    console.log('child 4 '+msg); 

                    if(  msg.includes(userId)  ){


                        var row1 = table2.insertRow(-1);
                        cell1 = row1.insertCell(-1);
                        cell1.innerHTML = "" ;
                        var link1 = document.createElement("a");
                         link1.className = "someCSSclass";
                        // link1.setAttribute("href", "view-user.php?"+"number="+number);
                          var linkText1 = document.createTextNode("");
                        link1.appendChild(linkText1);
                        cell1.appendChild(link1);

                      //  var row1 = table2.insertRow(-1);
                        cell1 = row1.insertCell(-1);
                        cell1.innerHTML = "" ;
                        var link1 = document.createElement("a");
                         link1.className = "someCSSclass";
                        // link1.setAttribute("href", "view-user.php?"+"number="+number);
                          var linkText1 = document.createTextNode(number);
                        link1.appendChild(linkText1);
                        cell1.appendChild(link1);
                       

                        cell1 = row1.insertCell(-1);
                        cell1.innerHTML = "" ;
                        var link1 = document.createElement("a");
                         link1.className = "someCSSclass";
                        // link1.setAttribute("href", "view-user.php?"+"number="+number);
                          var linkText1 = document.createTextNode("");
                        link1.appendChild(linkText1);
                        cell1.appendChild(link1);


                        var row = table.insertRow(-1);
                        cell = row.insertCell(-1);
                        cell.innerHTML = "" ;
                        var link = document.createElement("a");
                        link.className = "someCSSclass";
                        link.setAttribute("href", "view-user.php?"+"number="+number);
                         var linkText = document.createTextNode(number);
                        link.appendChild(linkText);
                        cell.appendChild(link);

                        //datee
                        cell = row.insertCell(-1);
                        cell.innerHTML = "" ;
                        var link = document.createElement("a");
                        link.className = "someCSSclass";
                        link.setAttribute("href", "view-user.php?"+"number="+number);

                         var linkText = document.createTextNode(date);
                        link.appendChild(linkText);
                        cell.appendChild(link);

                        //timee
                        cell = row.insertCell(-1);
    
                        cell.innerHTML = "" ;
                        var link = document.createElement("a");
                        link.className = "someCSSclass";
                        link.setAttribute("href", "view-user.php?"+"number="+number);

                         var linkText = document.createTextNode(time);
                        link.appendChild(linkText);
                        cell.appendChild(link);

                        cell = row.insertCell(-1);
    
                        cell.innerHTML = "" ;
                        var link = document.createElement("a");
                        link.className = "someCSSclass";
                        link.setAttribute("href", "view-user.php?"+"number="+number);

                         var linkText = document.createTextNode(msg);
                        link.appendChild(linkText);
                        cell.appendChild(link);

                        cell = row.insertCell(-1);
    
                        // cell.innerHTML = "" ;
                        // var link = document.createElement("a");
                        // link.className = "someCSSclass";
                        // link.style.color('pink');
                        // var linkText = document.createTextNode("View Chat");
                        // link.appendChild(linkText);
                        // cell.appendChild(link);

                        var btn = document.createElement('input');
                        btn.type = "button";
                        btn.className = "btn";
                        btn.value = "View Chat";
                        btn.setAttribute("href", "view-user.php?"+"number="+number);

                        btn.style.color = "white";
                        btn.style.backgroundColor = "#2196f3";
                        btn.onclick = (function(func) { window.location = "/user/view-user/"+number})

                        cell.appendChild(btn);
                        var row = table.insertRow(-1);

                    }
                    
                   
                   

                     });

                 });
                   

                      });

                      });
                   

                });

            });

          });
  
    });
}
