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
    const bigTextEvaluationStudents = document.getElementById('bigTextEvaluationStudents');


    var idoftheUser = document.getElementById('idoftheUser').value;


     var urlRef = firebase.database().ref().child('users').child(idoftheUser);
     urlRef.once("value", function(snapshot) {
       snapshot.forEach(function(child) {
       });
         });

    var table = document.querySelector('#table1 tbody');
    const dbEvaluationStudentsRef =firebase.database().ref().child('users').child(idoftheUser).child('people').child(userId).child('data');
    dbEvaluationStudentsRef.on('value', snapshot => {
        while(table.hasChildNodes()) {
            table.removeChild(table.firstChild);
              }
        snapshot.forEach(function(child) {
            var date = child.key;

            const time = firebase.database().ref().child('users').child(idoftheUser).child('people').child(userId).child('data').child(date);
            time.on('value', snapshot1 => {


                var count =0;
                snapshot1.forEach(function(child) {
                     count++;
                     
                });
                if(count>1){

                    snapshot1.forEach(function(child) {
                      //  var row = table.insertRow(-1);
                        var row = table.insertRow(-1);

                    cell = row.insertCell(-1);
                    cell.innerHTML = "" ;
                    var link = document.createElement("a");


                    link.className = "someCSSclass";
                    
                    var linkText = document.createTextNode(date);
                    link.appendChild(linkText);
                    cell.appendChild(link);
                        var time = child.key;

                        cell = row.insertCell(-1);
    
                        cell.innerHTML = "" ;
                        var link = document.createElement("a");
            
            
                        link.className = "someCSSclass";
                        
                         var linkText = document.createTextNode(time);
                        link.appendChild(linkText);
                        cell.appendChild(link);
                        
    
                        const message = firebase.database().ref().child('users').child(idoftheUser).child('people').child(userId).child('data').child(date).child(time);
                        message.on('value', snapshot3 => {
                       
                            snapshot3.forEach(function(child) {
                               
                              
                                
                                var msg = child.val();
                                cell = row.insertCell(-1);
                                cell.innerHTML = "" ;
                                var link = document.createElement("a");
    
                               // link.setAttribute("href", "view-user.php?"+"number=");
    
                                link.className = "someCSSclass";
                                
                                var linkText = document.createTextNode(msg);
                                link.appendChild(linkText);
                                cell.appendChild(link);
                               
                            });
                           

                    });
                  
               

                   
                    
                });
                
                }
                else {

                    snapshot1.forEach(function(child) {

                        var row = table.insertRow(-1);

                        console.log("DATE::: "+date); //getting the date nodes
                        cell = row.insertCell(-1);
                        cell.innerHTML = "" ;
                        var link = document.createElement("a");
    
    
                        link.className = "someCSSclass";
                        
                        var linkText = document.createTextNode(date);
                        link.appendChild(linkText);
                        cell.appendChild(link);

                        var time = child.key;
                        console.log("Time:::single   "+time); //getting the time nodes
    
                       
                        
                        cell = row.insertCell(-1);
    
                        cell.innerHTML = "" ;
                        var link = document.createElement("a");
            
            
                        link.className = "someCSSclass";
                        
                         var linkText = document.createTextNode(time);
                        link.appendChild(linkText);
                        cell.appendChild(link);
                        
    
                        const message = firebase.database().ref().child('users').child(idoftheUser).child('people').child(userId).child('data').child(date).child(time);
                        message.on('value', snapshot3 => {
                       
                            snapshot3.forEach(function(child) {
                               
    
                                var msg = child.val();
                                console.log("Time::: "+msg); //getting the message nodes
                                cell = row.insertCell(-1);
                                cell.innerHTML = "" ;
                                var link = document.createElement("a");
    
                                link.setAttribute("href", "view-user.php?"+"number=");
    
                                link.className = "someCSSclass";
                                
                                var linkText = document.createTextNode(msg);
                                link.appendChild(linkText);
                                cell.appendChild(link);
                                
                                
                            });
            
                    });
            
               

                   
                    
                });
            }

        });
                 
    });      
                  
        
          

      
  
    });
  }());