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


	// render the edit page
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

	    $sth = $app->db->prepare("SELECT * FROM tables");
		$sth->execute();
	    $tables = $sth->fetchAll(PDO::FETCH_ASSOC);

	    // Render index view
	    $app->render('edit.html', array(
	    		'attendants' => $attendants,
	    		'tables' => $tables
	    	)
	   	);
	});

	//updated attendants data
	$app->post('/edit', function () use ($app) {
		$attendants = $app->request->post('attendant');
		$success = array();
		$errors = array();

		foreach($attendants as $aid => $attendant) {
		    $sth = $app->db->prepare("UPDATE attendants
										SET	name = :name,
											address = :address,
											meal_id = :meal,
											rehearsal_dinner = :rehearsal_status,
											rehearsal_dinner_meal_id = :rehearsal_meal,
											rsvp = :status,
											gift = :gift,
											thank_you_card_sent = :tycard,
											table_id =:table
										WHERE id = :attendant_id");
		    $sth->bindParam(":name", $attendant['name']);
		    $sth->bindParam(":address", $attendant['address']);
		    $sth->bindParam(":meal", $attendant['meal']);
		    if((int)$attendant['rehearsal'] === 0) {
		    	$five = 5;
			    $sth->bindParam(":rehearsal_status", $attendant['rehearsal']);
			    $sth->bindParam(":rehearsal_meal", $five);
		    } else {
		    	$one = 1;
			    $sth->bindParam(":rehearsal_status", $one);
			    $sth->bindParam(":rehearsal_meal", $attendant['rehearsal']);
		    }
		    $sth->bindParam(":status", $attendant['status']);
		    $sth->bindParam(":gift", $attendant['gift']);
		    $sth->bindParam(":tycard", $attendant['tycard']);
		    $sth->bindParam(":table", $attendant['table']);
		    $sth->bindParam(":attendant_id", $aid);
		    if ($sth->execute()) $success[] = $attendant['name'];
		    else $errors[] = $attendant['name'];
		}

	    echo json_encode(array("success" => $success, "errors" => $errors));
	    exit;
	});

	$app->post('/new', function () use ($app) {

	});
