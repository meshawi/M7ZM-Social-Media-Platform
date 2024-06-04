<?php
// Start session and include config
session_start();
require_once "../backend/config.php";
require_once '../backend/auth_check.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>Chat</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <?php require ("./navbar.php"); ?>
    <link rel="stylesheet" href="../css/user_chat.css">

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Users</h4>
                <div id="userList" class="list-group">
                    <!-- Users will be loaded here -->
                </div> <a href="../pages/search_user.php" class="btn btn-primary ml-6 mt-5">Look up users </a>

            </div>

            <div class="col-md-8">
                <div id="chatSection" style="display:none;">
                    <h4>Chat</h4>
                    <div id="chatHeader" class="mb-2">
                        <h5 id="chatPartnerName"></h5>
                    </div>

                    <div id="chatWindow" class="border rounded " style="height: 650px; overflow-y: scroll;">
                        <!-- Messages will be displayed here -->
                    </div>
                    <div class="chat-input">
                        <textarea id="messageInput" class="form-control mt-3" placeholder="Type a message..."
                            rows="1"></textarea>
                        <button onclick="window.sendMessage()" class="btn"><i class="fa fa-paper-plane"></i></button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        var selectedUserId = null; // Global variable to track the selected user ID
        $('#messageInput').on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        $(document).ready(function () {
            window.fetchUsers = function () {
                $.ajax({
                    url: '../backend/fetch_users.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (users) {
                        $('#userList').empty();
                        users.forEach(function (user) {
                            $('#userList').append(
                                `<a href="#" class="list-group-item list-group-item-action" data-user-id="${user.id}" onclick="selectUser(${user.id}, '${user.fullname.replace(/'/g, "\\'")}')">${user.username} (${user.status})</a>`
                            );
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching users:", status, error);
                    }
                });
            };

            function fetchMessages() {
                if (selectedUserId) {
                    console.log("Polling for messages for user ID:", selectedUserId);
                    $.ajax({
                        url: '../backend/fetch_messages.php',
                        method: 'POST',
                        data: { user_id: selectedUserId },
                        dataType: 'json',
                        success: function (messages) {
                            $('#chatWindow').empty();
                            if (messages.length > 0) {
                                messages.forEach(function (message) {
                                    const alignClass = message.sender_id == <?php echo $_SESSION['id']; ?> ? 'sender' : 'receiver';
                                    const messageHtml = `
                                        <div class="message ${alignClass}">
                                            <img src="${message.profile_image}" alt="${message.fullname}" class="profile-image">
                                            <div class="message-info">
                                                <span class="message-content">${message.message}</span>
                                                <span class="message-timestamp">${new Date(message.timestamp).toLocaleTimeString()}</span>
                                            </div>
                                        </div>
                                    `;
                                    $('#chatWindow').append(messageHtml);
                                });
                            } else {
                                $('#chatWindow').append('<div>No messages found.</div>');
                            }
                            $('#chatWindow').scrollTop($('#chatWindow')[0].scrollHeight);
                        },
                        error: function (xhr, status, error) {
                            console.error("Error fetching messages:", status, error);
                        }
                    });
                }
            }

            // Function to handle user selection
            window.selectUser = function (userId, fullname) {
                $('#userList').find('a').removeClass('active');
                $(`a[data-user-id="${userId}"]`).addClass('active');
                selectedUserId = userId;
                $('#chatPartnerName').text(fullname); // Update the chat header with the fullname
                $('#chatSection').show();
                fetchMessages(); // Fetch messages immediately upon user selection
            };
            fetchUsers();
            setInterval(fetchMessages, 5000); // Poll for new messages every 5 seconds
        });

        window.sendMessage = function () {
            const message = $('#messageInput').val().trim();
            if (message && selectedUserId) {
                console.log("Sending message:", message, "to user ID:", selectedUserId);
                $.ajax({
                    url: '../backend/send_message.php',
                    method: 'POST',
                    data: { message: message, user_id: selectedUserId },
                    success: function (response) {
                        $('#messageInput').val('');
                        fetchMessages(); // Refresh messages after sending
                        console.log("Message sent successfully:", response);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, "Details:", errorThrown);
                    }
                });
            } else {
                console.log("Message or user ID missing.");
            }
        };
    </script>
</body>

</html>