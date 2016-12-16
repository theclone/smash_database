var counter = 1;
var limit = 3;
function addInput(divName){
     if (counter == limit)  {
          alert("you have reached the limit of adding " + counter + " secondaries");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "secondary " + (counter + 1) + ": <br><input type='text' name='secondary[]'>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}
