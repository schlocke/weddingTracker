<?php

	// Define routes
	$app->get('/', function () use ($app) {
	    $sth = $app->db->prepare("SELECT a.*, b.name as meal_name, c.name as rehearsal_dinner_meal_name, d.status, e.name as table_name FROM attendants as a
	    							INNER JOIN meals as b
	    								ON a.meal_id = b.id
	    							INNER JOIN rehearsal_dinner_meals as c
	    								ON a.rehearsal_dinner_meal_id = c.id
	    							INNER JOIN rsvp_status as d
	    								ON a.rsvp = d.id
	    							INNER JOIN tables as e
	    								ON a.table_id = e.id
	    							ORDER BY a.id ASC");
		$sth->execute();
	    $attendants = $sth->fetchAll(PDO::FETCH_ASSOC);

	    // Render index view
	    $app->render('index.html', array(
	    		'attendants' => $attendants
	    	)
	   	);
	});


	// Define routes
	$app->get('/edit', function () use ($app) {
	    $sth = $app->db->prepare("SELECT a.*, b.name as meal_name, c.name as rehearsal_dinner_meal_name, d.status, e.name as table_name FROM attendants as a
	    							INNER JOIN meals as b
	    								ON a.meal_id = b.id
	    							INNER JOIN rehearsal_dinner_meals as c
	    								ON a.rehearsal_dinner_meal_id = c.id
	    							INNER JOIN rsvp_status as d
	    								ON a.rsvp = d.id
	    							INNER JOIN tables as e
	    								ON a.table_id = e.id
	    							ORDER BY a.id ASC");
		$sth->execute();
	    $attendants = $sth->fetchAll(PDO::FETCH_ASSOC);

	    // Render index view
	    $app->render('edit.html', array(
	    		'attendants' => $attendants
	    	)
	   	);
	});