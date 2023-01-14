function readMessage() {
    $.ajax({
        type: 'post',
        url: './message.log'
        })
    .then(
        function (data) {
            log = data.replace(/[\n\r]/g, "<br />");
            $('#messageTextBox').html(log);
        },
        function () {
            
        }
    );
}
function TypeCheck() {
      $.ajax({
        type: 'post',
        url: './type.txt'
        })
    .then(
        function (data) {
            log = data.replace(/[\n\r]/g, "<br />");
            $('#type').html(log);
        },
        function () {
            
        }
    );
}

function TypeWrite() {
  $.ajax({
        type: 'post',
        url: './type.php',
        data: {
            'message' : $("#aaaaaa").val()
        }
    })
    .then(
        function (data) {
            readMessage();
            $("#aaaa").val('');
        },
        function () {
            
        }
    );
}

function TypeblankWrite() {
  $.ajax({
        type: 'post',
        url: './type-blank.php',
        data: {
            'message' : $("#aaaaaa").val()
        }
    })
    .then(
        function (data) {
            readMessage();
            $("#aaaa").val('');
        },
        function () {
            
        }
    );
}

function writeMessage() {
    $.ajax({
        type: 'post',
        url: './main.php',
        data: {
            'message' : $("#message").val()
        }
    })
    .then(
        function (data) {
            readMessage();
            $("#message").val('');
        },
        function () {
            
        }
    );
}



$(document).ready(function() {
    readMessage();
    TypeCheck();
    TypeblankWrite();
    setInterval('readMessage()', 3000);
    setInterval('TypeCheck()', 3000);
  setInterval('TypeblankWrite()', 5000);
});

