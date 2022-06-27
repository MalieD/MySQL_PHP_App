var myData;

function TestExecuteQuery() {
  $myFunction = "ExecQuery";
  $queryFunction = "GetAllByROWID";

  $params = Array();
  AddParam($params, "integer", 4);

  ExecQuery($myFunction, $queryFunction, $params, testCalback);
}
function testCalback(data) {
  myData = data;
  console.log(myData);
}

function AddParam(Params, DataType, Value) {
  Params.push({ dataType: DataType, value: Value });
}

function ExecQuery(myFunction, myQuery, myParams, callback) {
  // Functie om diverse database select queries mee uit
  // te voeren en resultaat in te lezen.
  if (myParams == null) {
    $postData = {
      function2call: myFunction,
      queryFunction: myQuery,
    };
  } else {
    $postData = {
      function2call: myFunction,
      queryFunction: myQuery,
      params: myParams,
    };
  }

  $.ajax({
    url: "API.php",
    type: "post",
    data: $postData,
    dataType: "json",
    success: function (response) {
      if (response.Exitcode != 100) {
        // Als er een fout is opgetreden
        alert("Exitcode !100 : " + response.Exitcode);
      } else {
        callback(response.data);
      }
    },
    error: function (response) {
      //alert("Error-> " + response.Exitcode);
      console.log("Error-> " + response.Exitcode);
    },
  });
}
