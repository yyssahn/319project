CREATE TABLE IF NOT EXISTS CategoryOptions(
	iid int NOT NULL PRIMARY KEY,
	idea_type varchar(50),
	referral varchar(50),
	mandate varchar(50),
	focus varchar(50),
	main_activities varchar(50),
	delivery_location varchar(50),
	disciplines varchar(50),
	timeframe varchar(50),
	status varchar(50)
);

INSERT INTO CategoryOptions values(
	1,
	'One-Time Project',
	'Course-Based Opportunity',
	'Aboriginal Engagement',
	'Aboriginal Engagement',
	'Consultation',
	NULL,
	NULL,
	NULL,
	'Initial Idea Inputted'	
);

INSERT INTO CategoryOptions values(
	2,
	'Recurring Project',
	'Trek Program',
	'Arts - Culture - Heritage',
	'Arts - Culture - Heritage',
	'Curriculum Development',
	NULL,
	NULL,
	NULL,
	'Assigned Ownership'
);

INSERT INTO CategoryOptions values(
	3,
	'Part of a Multi-Phase Project',
	'Reading Week Project',
	'Civic Participation - Politics - Democracy',
	'Civic Participation - Politics - Democracy',
	'Data Gathering and Mapping',
	NULL,
	NULL,
	NULL,
	'Active Development'
);