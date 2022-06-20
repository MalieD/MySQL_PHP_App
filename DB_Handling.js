var myData;

function TestExecuteQuery() {
  $queryFunction = "GetAllIDs";
  $params = null;
  ExecQuery($queryFunction, $params, test);
}

function ExecQuery(myQuery, myParams, callback) {
  // Functie om diverse database select queries mee uit
  // te voeren en resultaat in te lezen.
  if (myParams == null) {
    $postData = {
      function2call: "ExecQuery",
      queryFunction: myQuery,
    };
  } else {
    $postData = {
      function2call: "ExecQuery",
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
      debugger;
      alert("Error-> " + response.Exitcode);
    },
  });
}

function test(data) {
  myData = data;
  console.log(myData);
}
