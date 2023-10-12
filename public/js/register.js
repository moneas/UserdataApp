$(document).ready(function () {
    $.get('/api/countries', function(data) {
        var countrySelect = $('#country_id');
        countrySelect.empty();
        countrySelect.append($('<option>', {
            value: '',
            text: 'Select Country'
        }));
        $.each(data.countries, function(key, value) {
            countrySelect.append($('<option>', {
                value: value.id,
                text: value.name
            }));
        });
    });
    $('#registration-form').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        var password = $('#password').val();
        var confirmPassword = $('#password_confirmation').val();

        if (password !== confirmPassword) {
            $('#registration-messages').html('<div class="alert alert-danger">Password and Confirm Password do not match.</div>');
            return;
        }

        $.ajax({
            url: '/api/register', // Change the URL to /api/register
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Save the token to localStorage
                    localStorage.setItem('token', response.token);
                    window.location.href = '/user-list';
                } else {
                    var messages = '';
                    if (response.errors) {
                        for (var key in response.errors) {
                            messages += response.errors[key].join('<br>') + '<br>';
                        }
                    }
                    $('#registration-messages').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(data) {
                $('#registration-messages').html('<div class="alert alert-danger">' + data.responseJSON.message + '</div>');
            }
        });      
    });
});
