var deleteId;

// Display user alert
function showAlert(classType, message) {
    if (classType == 'success') {
        $('#user-alert').removeClass('error-alert');
        $('#user-alert').addClass('success-alert');
    } else {
        $('#user-alert').removeClass('success-alert');
        $('#user-alert').addClass('error-alert');
    }
    $('#user-alert').html(message);
    $('#user-alert').show();
}

// List users
function listUsers() {
    $('#spinner').show();
    $('#content').load('users.html', '', function() {
        var users = [];
        $.ajax({
            url: 'backend/routes.php?get_action=list',
            method: 'GET',
            success: function(data) {
                $('#spinner').hide();
                users = JSON.parse(data);
                users.forEach(function (user) {
                    $('#users-table > tbody:last-child').append('<tr><td class="pt-3">' + user.id + '</td><td class="pt-3">' + user.first_name + 
                        '</td><td class="pt-3">' + user.surname + '</td><td class="pt-3">' + user.email + '</td>' + 
                        '<td class="px-1"><button class="edit-button" onclick="editClick(' + user.id + ')">Edit</button></td>' + 
                        '<td class="px-1"><button class="delete-button" onclick="deleteClick(' + user.id + ')" ' + 
                        'data-toggle="modal" data-target="#confirmModal">Delete</button></td></tr>');
                });
            },
            error: function(error) {
                $('#spinner').hide();
                showAlert('error', 'An error occurred');
            }
        });
    });
}

// Add button clicked
function addClick() {
    $('#user-alert').hide();
    $('#spinner').show();
    $('#content').load('create.html', '', function() { 
        $('#spinner').hide();
    });
}

// Add a user
function addUser() {
    var firstName = $('#first-name').val();
    var surname = $('#surname').val();
    var email = $('#email').val();
    var username = $('#username').val();
    var password = $('#password').val();
    
    if (!firstName || !surname || !email || !username || !password) {
        showAlert('error', 'Please check your entry, fields with errors are highlighted in red');
        $('input').each(function() {
            if ($(this).val() == '') { 
                $(this).css('background-color', '#f8d7da');
            }
        });
        return;
    }
    
    $('#spinner').show();
    $.ajax({
        url: 'backend/routes.php',
        method: 'POST',
        data: {'post_action':'create', 'first_name':firstName, 'surname':surname, 'email':email, 'username':username, 'password':password},                
        success: function(data) {
            $('#spinner').hide();
            if (data == true) {
                listUsers();
                showAlert('success', 'Your submission has been successful');
            } else {
                showAlert('error', 'An error occurred');
            }
        },
        error: function(error) {
            $('#spinner').hide();
            showAlert('error', 'An error occurred');
        }
    });
}

// Edit button clicked
function editClick(userId) {
    $('#user-alert').hide();
    $('#spinner').show();
    $('#content').load('update.html', '', function() {    
        $.ajax({
            url: 'backend/routes.php?get_action=get&user_id=' + userId,
            method: 'GET',
            success: function(data) {
                $('#spinner').hide();
                var user = JSON.parse(data);
                $('#first-name').val(user.first_name);
                $('#surname').val(user.surname);
                $('#email').val(user.email);
                $('#username').val(user.username);
                $('#password').val(user.password);
                $('#user-id').val(userId);
            },
            error: function(error) {
                $('#spinner').hide();
                showAlert('error', 'An error occurred');
            }
        });
    });
}

// Update a user
function updateUser() {
    var firstName = $('#first-name').val();
    var surname = $('#surname').val();
    var email = $('#email').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var userId = $('#user-id').val();
    
    if (!firstName || !surname || !email || !username || !password) {
        showAlert('error', 'Please check your entry, fields with errors are highlighted in red');
        $('input').each(function() {
            if ($(this).val() == '') { 
                $(this).css('background-color', '#f8d7da');
            }
        });
        return;
    }
    
    $('#spinner').show();
    $.ajax({
        url: 'backend/routes.php',
        method: 'POST',
        data: {'post_action':'update', 'first_name':firstName, 'surname':surname, 'email':email, 'username':username, 'password':password, 
            'user_id':userId},
        success: function(data) {
            $('#spinner').hide();
            if (data == true) {
                listUsers();
                showAlert('success', 'Your submission has been successful');
            } else {
                showAlert('error', 'An error occurred');
            }
        },
        error: function(error) {
            $('#spinner').hide();
            showAlert('error', 'An error occurred');
        }
    });
}

// Delete button clicked
function deleteClick(userId) {
    deleteId = userId;
}

// Delete confirmed
function deleteConfirmed() {
    $('#spinner').show();
    $.ajax({
        url: 'backend/routes.php?get_action=delete&user_id=' + deleteId,
        method: 'GET',
        success: function(data) {
            $('#spinner').hide();
            if (data == true) {
                listUsers();
                showAlert('success', 'User deleted successfully');
            } else {
                showAlert('error', 'An error occurred');
            }
        },
        error: function(error) {
            $('#spinner').hide();
            showAlert('error', 'An error occurred');
        }
    });
}

