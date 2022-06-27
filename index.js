function run() {
  StartMatrix();
  SkipInlog();
  //TestExecuteQuery();
  ExecQuery("GetData", "GetAllTextFiles", Array(), ShowAllTextFiles);
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
  debugger;
  var file = $(`.${source}`);  
  var params = Array();  
  AddParam(params, "string", filename);
  ExecQuery("GetData", "GetTextFile", params, ShowContents);

  $(file).addClass("itemSelected");
}

function ShowContents(data) {
  console.log(data);
}
