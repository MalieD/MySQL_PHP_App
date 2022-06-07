var tileSize = 20;
// a higher fade factor will make the characters fade quicker
var fadeFactor = 0.05;
var title3DD = "3DD-DEV-API UNDER CONSTRUCTION ";
var titleOffset = 30;
var canvas;
var ctx;
var ignoreEnter = false;

var columns = [];
var maxStackHeight;

function StartMatrix() {
  canvas = document.getElementById("canvas");
  ctx = canvas.getContext("2d");

  //$(ctx).css("background-color", "white");
  $(ctx).animate(
    {
      backgroundColor: "#000000",
    },
    {
      duration: 1000,
      specialEasing: {
        width: "linear",
      },
      complete: function () {
        init();
      },
    }
  );
}

function init() {
  initMatrix();

  // start the main loop
  tick();
}

function initMatrix() {
  maxStackHeight = Math.ceil(canvas.height / tileSize);

  // divide the canvas into columns
  for (let i = 0; i < canvas.width / tileSize; ++i) {
    var column = {};
    // save the x position of the column
    column.x = i * tileSize;
    // create a random stack height for the column
    column.stackHeight = 10 + Math.random() * maxStackHeight;
    // add a counter to count the stack height
    column.stackCounter = 0;
    // add the column to the list
    columns.push(column);
  }
}

function draw() {
  // draw a semi transparent black rectangle on top of the scene to slowly fade older characters
  ctx.fillStyle = "rgba( 0 , 0 , 0 , " + fadeFactor + " )";
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  // pick a font slightly smaller than the tile size
  ctx.font = tileSize - 2 + "px monospace";
  ctx.fillStyle = "rgb( 0 , 255 , 0 )";

  for (let i = 0; i < columns.length; ++i) {
    // pick a random ascii character (change the 94 to a higher number to include more characters)
    var randomCharacter = String.fromCharCode(
      33 + Math.floor(Math.random() * 94)
    );
    if (i == titleOffset - 1 || i == title3DD.length + titleOffset - 1) {
      var randomCharacter = "|";
    } else if (i >= titleOffset && i < title3DD.length + titleOffset) {
      var randomCharacter = title3DD.charAt(i - titleOffset);
    }
    ctx.fillText(
      randomCharacter,
      columns[i].x,
      columns[i].stackCounter * tileSize + tileSize
    );

    // if the stack is at its height limit, pick a new random height and reset the counter
    if (++columns[i].stackCounter >= columns[i].stackHeight) {
      columns[i].stackHeight = 10 + Math.random() * maxStackHeight;
      columns[i].stackCounter = 0;
    }
  }
}

// MAIN LOOP
function tick() {
  draw();
  setTimeout(tick, 50);
}

$(document).on("keypress", function (key) {
  if (key.which == 13) {
    if (ignoreEnter == false) {
      showEnterPasswordForm();
    }
    ignoreEnter = false;
  }
});

function showEnterPasswordForm() {
  $("body").append(`<div class="EnterPasswordForm">
                              <div class="EnterPasswordForm_Password">Enter Password:
                                  <div class="EnterPasswordForm_InputField">                
                                      <input type="password" class="password" name="password" onkeydown="EnterPassword(this)"><br><br>
                                  </div>            
                              </div>
                          </div>`);

  $(".password").focus();
}

function EnterPassword(password) {
  if (event.key === "Enter") {
    ignoreEnter = true;
    var pwd = $(".password").val();

    $(".EnterPasswordForm").remove();

    if (pwd == "test") {
      $(".DevellopCenter").show();
      $(".DevellopCenter").focus();
      $(".canvasStyle").hide();
    }    
  } else if (event.key === "Escape") {
    $(".EnterPasswordForm").remove();
  }
}
