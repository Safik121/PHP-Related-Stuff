$(document).ready(function() {
    // Check if user is already logged in
    checkLoginStatus();

    // Login form submission
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        login(formData);
    });

    // Register form submission
    $('#registerForm').on('submit', function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        register(formData);
    });

    // Logout button click
    $('#logoutButton').on('click', function(event) {
        event.preventDefault();
        logout();
    });

    $('#playButton').on('click', function(event) {
        event.preventDefault();
        play();
    });

    function play() {
        $.ajax({
            type: 'POST',
            url: 'lobby_handle.php',
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    //$('#message').text("Welcome, " + data.message);
                    //$('#chessboardContainer').html(data.chessboard);
                    window.location.href = 'index.php'
                } else {
                    alert("Failed to create/join lobby.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("An error occurred while creating/joining lobby.");
            }
        });
    }

    function checkLoginStatus() {
        // Simulate checking login status (replace this with actual code)
        var isLoggedIn = localStorage.getItem('loggedIn');
        var username = localStorage.getItem('username');
        var wins = localStorage.getItem('wins');
        var losses = localStorage.getItem('losses');
        
        if (isLoggedIn === 'true' && username) {
            $('#loggedInUser').text("Logged in as: " + username);
            $('#userWins').text("Wins: " + wins);
            $('#userLosses').text("Losses: " + losses);
            $('#userInfoDiv').show();
            $('#loginForm').hide();
            $('#registerForm').hide();
            $('#logoutButton').show();
            $('#playButton').show();
        }
    }

    function login(formData) {
        $.ajax({
            type: 'POST',
            url: 'login.php', // Update with your login handling endpoint
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    localStorage.setItem('loggedIn', 'true');
                    localStorage.setItem('username', data.username);
                    localStorage.setItem('wins', data.wins);
                    localStorage.setItem('losses', data.losses);
                    $('#loggedInUser').text("Logged in as: " + data.username);
                    $('#userWins').text("Wins: " + data.wins);
                    $('#userLosses').text("Losses: " + data.losses);
                    $('#userInfoDiv').show();
                    $('#loginForm').hide();
                    $('#registerForm').hide();
                    $('#logoutButton').show();
                    $('#playButton').show();
                } else {
                    alert(data.message); // Show error message
                }
            },
            error: function(xhr, status, error) {
                console.error("Login error:", error);
                alert("An error occurred while logging in. Please try again.");
            }
        });
    }

    function register(formData) {
        $.ajax({
            type: 'POST',
            url: 'register.php',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    localStorage.setItem('loggedIn', 'true');
                    localStorage.setItem('username', data.username);
                    localStorage.setItem('wins', data.wins);
                    localStorage.setItem('losses', data.losses);
                    $('#loggedInUser').text("Logged in as: " + data.username);
                    $('#userWins').text("Wins: " + data.wins);
                    $('#userLosses').text("Losses: " + data.losses);
                    $('#userInfoDiv').show();
                    $('#loginForm').hide();
                    $('#registerForm').hide();
                    $('#logoutButton').show();
                    $('#playButton').show();
                } else {
                    alert(data.message); // Show error message
                }
            },
            error: function(xhr, status, error) {
                console.error("Registration error:", error);
                alert("An error occurred while registering. Please try again.");
            }
        });
    }

    function logout() {
        localStorage.removeItem('loggedIn');
        localStorage.removeItem('username');
        localStorage.removeItem('wins');
        localStorage.removeItem('losses');
        $('#userInfoDiv').hide();
        $('#loginForm').show();
        $('#registerForm').show();
        $('#logoutButton').hide();
        $('#playButton').hide();
    }
});

