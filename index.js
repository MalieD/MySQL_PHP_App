function run() {
  StartMatrix();
  //SkipInlog();
}

function ShowAllPictures() {}

function ShowAllTextFiles(data) {
  var elemID = "";

  if (data != null) {
    data.forEach((element) => {
      elemID = element.replace(".", "_");
      $(".panelLeft").append(
        `<div class="item ${elemID}" onClick="OpenFile('${elemID}', '${element}')">${element}</div>`
      );
    });
  }
}

function OpenFile(source, filename) {
  var file = $(`.${source}`);
  var params = Array();
  AddParam(params, "string", filename);
  ExecQuery("GetData", "GetTextFile", params, ShowContents);

  $(file).addClass("itemSelected");
}

function ShowContents(data) {
  var image = new Image();
  image.src = "data:image/png;base64," + data;
  //$(".panelRight")[0].innerText = data;
  $(".panelRight").append(image);
}
