<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

include 'model.php';

$db = connect_db('localhost', 'ddwt18_week1', 'ddwt18','ddwt18');

/* Landing page */
if (new_route('/DDWT18/week1/', 'get')) {
    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Home' => na('/DDWT18/week1/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', True),
        'Overview' => na('/DDWT18/week1/overview/', False),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'The online platform to list your favorite series';
    $page_content = 'On Series Overview you can list your favorite series. You can see the favorite series of all Series Overview users. By sharing your favorite series, you can get inspired by others and explore new series.';

    /* Choose Template */
    include use_template('main');
}

/* Overview page */
elseif (new_route('/DDWT18/week1/overview/', 'get')) {
    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $series_exp = get_series($db);
    $left_content = get_serie_table($series_exp);

    /* Choose Template */
    include use_template('main');
}

/* Single Serie */
elseif (new_route('/DDWT18/week1/serie/', 'get')) {
    /* Get series from db */
    $serie_id = $_GET['serie_id'];
    $series_info_exp = get_series_info($db, $serie_id);
    $serie_name = $series_info_exp['name'];
    $serie_abstract = $series_info_exp['abstract'];
    $nbr_seasons = $series_info_exp['seasons'];
    $creators = $series_info_exp['creator'];
    $serie_id = $_GET['serie_id'];

    /* Page info */
    $page_title = $serie_name;
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview/', False),
        $serie_name => na('/DDWT18/week1/serie/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Information about %s", $serie_name);
    $page_content = $serie_abstract;

    /* Choose Template */
    include use_template('serie');
}

/* Add serie GET */
elseif (new_route('/DDWT18/week1/add/', 'get')) {
    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Add Series' => na('/DDWT18/week1/new/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', False),
        'Add Series' => na('/DDWT18/week1/add/', True)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = "Add Series";
    $form_action = '/DDWT18/week1/add/';

    /* Choose Template */
    include use_template('new');
}

/* Add serie POST */
elseif (new_route('/DDWT18/week1/add/', 'post')) {
    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Add Series' => na('/DDWT18/week1/add/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', False),
        'Add Series' => na('/DDWT18/week1/add/', True)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = "Add Series";
    $form_action = '/DDWT18/week1/add/';
    $feedback = add_series($_POST, $db);
    $error_msg = get_error($feedback);

    include use_template('new');
}

/* Edit serie GET */
elseif (new_route('/DDWT18/week1/edit/', 'get')) {
    /* Get serie info from db */
    $serie_id = $_GET['serie_id'];
    $series_info = get_series_info($db, $serie_id);
    $serie_name = $series_info['name'];
    $serie_abstract = $series_info['abstract'];
    $nbr_seasons = $series_info['seasons'];
    $creators = $series_info['creator'];

    /* Page info */
    $page_title = 'Edit Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        sprintf("Edit Series %s", $serie_name) => na('/DDWT18/week1/new/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', False),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Edit %s", $serie_name);
    $page_content = 'Edit the series below.';
    $submit_btn = "Edit Series";
    $form_action = "/DDWT18/week1/edit/?serie_id=$serie_id";

    /* Choose Template */
    include use_template('new');
}

/* Edit serie POST */
elseif (new_route('/DDWT18/week1/edit/', 'post')) {

    $serie_id = $_GET['serie_id'];
    $feedback = update_series($serie_id, $_POST, $db);
    $error_msg = get_error($feedback);

    /* Get serie info from db */
    $series_info = get_series_info($db, $serie_id);
    $serie_name = $series_info['name'];
    $serie_abstract = $series_info['abstract'];
    $nbr_seasons = $series_info['seasons'];
    $creators = $series_info['creator'];

    /* Page info */
    $page_title = $series_info['name'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview/', False),
        $serie_name => na('/DDWT18/week1/serie/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', False),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Information about %s", $serie_name);
    $page_content = $series_info['abstract'];
    $submit_btn = "Edit Series";
    $form_action = "/DDWT18/week1/edit/?serie_id=$serie_id";

    /* Choose Template */
    include use_template('serie');
}

/* Remove serie */
elseif (new_route('/DDWT18/week1/remove/', 'post')) {
    /* Remove serie in database */
    $serie_id = $_POST['serie_id'];
    $feedback = remove_serie($db, $serie_id);
    $error_msg = get_error($feedback);

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $series_exp = get_series($db);
    $left_content = get_serie_table($series_exp);

    /* Choose Template */
    include use_template('main');
}

else {
    http_response_code(404);
}