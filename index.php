<?php
    // Auto Loader
    // TODO: Change to Composer Loader
    declare( strict_types=1 );

    spl_autoload_register(function ($class) {
        require __DIR__ . "/src/$class.php";
    });

    // Exception Handler
    set_exception_handler("ErrorHandler::handleException");

    $parts = explode( "/", $_SERVER[ "REQUEST_URI" ]);

    if ( $parts[ 1 ] != "api" ) {
        echo '<h1> 404 Not Found1 </h1>';
        http_response_code( 404 );
        exit;
    }

    $id = $parts[ 3 ] ?? null;

    // Database
    // TODO: Put Info in Config
    $database = new Database( "localhost", "file_upload_db", "root", "root" );
    $gateway = new UploadGateway( $database );

    // Controller
    $controller = new UploadController( $gateway );

    if ( $parts[ 2 ] === "upload" ) {
        header( "Content-type: application/json; charset=UTF-8" );

        $controller -> processRequest( $_SERVER[ "REQUEST_METHOD" ], $id );
        exit;
    }

    else if ( $parts[ 2 ] === "files" && $id ) {

        // Set Header
        // echo $id; // Get Filename
        $mimetype = mime_content_type( "files/$id" );
        // echo $mimetype;

        if ( $mimetype === 'application/pdf' ) {

            // Header content type
            header( 'Content-type: ' . $mimetype );
            
            header( 'Content-Disposition: inline; filename="' . $id . '"' );
            
            header( 'Content-Transfer-Encoding: binary' );
            
            header( 'Accept-Ranges: bytes' );
            
            // Read the file
            @readfile( "files/$id" );
        }
        
        else {
            // Using <img> Tag
            // Get image data
            $imageData = file_get_contents( "files/$id" );

            // Encode image data to base64
            $base64 = base64_encode( $imageData );

            echo '<img src="data:' . $mimetype . ';base64,' . $base64 . '">';
        }
        exit;
    }

    else {
        echo '<h1> 404 Not Found </h1>';
        http_response_code( 404 );
        exit;
    }

?>