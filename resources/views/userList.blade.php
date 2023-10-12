@extends('layouts.app')

@section('title', 'User List')

@section('content')
    <h2 class="mt-5">User List</h2>
    
        <p class="mt-3">Welcome Member <a href="#" id="logout">Logout</a></p>
        <table class="table mt-4" id="user-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Country</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
        <script>
        $(document).ready(function () {
        var token = localStorage.getItem('token');
        if (!token) {
        window.location.href = "/";
        }

        $.ajax({
            url: '/api/user-list',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token, 
            },
            dataType: 'json',
            success: function (response) {
                if (response.users) {
                    var users = response.users;
                    var tableBody = $('#user-table tbody');

                    tableBody.empty();

                    $.each(users, function (key, user) {
                        var newRow = '<tr>' +
                            '<td>' + user.name + '</td>' +
                            '<td>' + user.email + '</td>' +
                            '<td>' + user.date_of_birth + '</td>' +
                            '<td>' + user.country.name + '</td>' +
                            '</tr>';

                        tableBody.append(newRow);
                    });
                }
            },
            error: function (data) {
                console.log(data);
            }
        });

        $('#logout').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: '/api/logout',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token, 
                },
                success: function (response) {
                    localStorage.removeItem('token');
                },
                error: function (data) {
                    console.log(data);
                }
            });
            window.location.href = '/';
        });
    });

    </script>
    
@endsection
