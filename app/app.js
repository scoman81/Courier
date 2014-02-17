// app.js
var app = angular.module("app", ['ui.router']);

app.config(['$stateProvider','$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
  
  // catch unmatched URLS
  $urlRouterProvider.otherwise("/");

  // states
  $stateProvider
    .state('home', {
      url: '/',
      templateUrl: 'templates/home.html'
    })
    .state('contacts', {
      url: '/contacts',
      templateUrl: 'templates/contacts.html'
    })
    .state('messages', {
      url: '/messages'
    })

}])