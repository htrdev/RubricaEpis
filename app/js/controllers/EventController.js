'use strict';

eventsApp.controller('EventController',
	function EventController($scope)
	{
		$scope.event = {
			name: 'Angular Boot Camp',
			date : '1/1/2013',
			time: '10:30pm',
			location:{
				address: 'Google Headquarters',
				city: 'Mountain View',
				province: 'CA'
			},
			imageUrl : 'img/angularjs-logo.png',
			sessions:[
				{
					name : 'Sesion 1',
					creatorName :  'Charlie Ochoa',
					duration: ' 2 hrs',
					level: 'Advances',
					abstract: 'Would be really nice to have',
					upVoteCount:3
				},
				{
					name : 'Sesion 2',
					creatorName : 'Charlie Ochoa',
					duration: ' 2 hrs',
					level: 'Advances',
					abstract: 'Would be really nice to have',
					upVoteCount:2
				},
				{
					name : 'Sesion 3',
					creatorName : 'Charlie Ochoa',
					duration: ' 2 hrs',
					level: 'Advances',
					abstract: 'Would be really nice to have',
					upVoteCount:35
				},
			]
		}
		$scope.upVoteSession = function(session){
			session.upVoteCount++;
		}

		$scope.downVoteSession = function(session){
			session.upVoteCount--;
		}
	});