// MySQL API
var apis = 'api.php';

// Replace with: your firebase account
var config = {
    apiKey: "AIzaSyBrVrMNGfaJauUyJZaZJkJ0IgGU9MlrFsY",
    databaseURL: "https://frasindo-chat-dashboard.firebaseio.com",
};
firebase.initializeApp(config);

// create firebase child
var dbRef = firebase.database().ref(),
	messageRef = dbRef.child('message'),
	userRef = dbRef.child('user');
