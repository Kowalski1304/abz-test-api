<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>

<div>
    <button id="fetchDataButton" type="button" class="btn btn-secondary">Show more</button>
    <div id="userDataContainer"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#fetchDataButton').click(function () {
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/v1/users?page=1&count=6',
                    type: 'GET',
                    success: function (data) {
                        displayUserData(data);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            function displayUserData(data) {
                $('#userDataContainer').empty();

                var html = '<p>Page: ' + data.page + '</p>' +
                    '<p>Total Pages: ' + data.total_pages + '</p>' +
                    '<p>Total Users: ' + data.total_users + '</p>' +
                    '<p>Count: ' + data.count + '</p>' +
                    '<p>Next URL: ' + (data.links.next_url ? data.links.next_url : 'None') + '</p>' +
                    '<p>Previous URL: ' + (data.links.prev_url ? data.links.prev_url : 'None') + '</p>' +
                    '<h3>Users:</h3><ul>';

                data.users.forEach(function (user) {
                    html += '<li>' +
                        '<p>ID: ' + user.id + '</p>' +
                        '<p>Name: ' + user.name + '</p>' +
                        '<p>Email: ' + user.email + '</p>' +
                        '<p>Phone: ' + user.phone + '</p>' +
                        '<p>Position: ' + user.position + '</p>' +
                        '<p>Position ID: ' + user.position_id + '</p>' +
                        '<p>Registration Timestamp: ' + user.registration_timestamp + '</p>' +
                        '<p>Photo: ' + user.photo + '</p>' +
                        '</li>';
                });

                html += '</ul>';

                $('#userDataContainer').html(html);
            }
        });
    </script>
</div>

</body>
</html>
