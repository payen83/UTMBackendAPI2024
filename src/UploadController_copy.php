<?php
    class UploadController
    {
        public function __construct( private UploadGateway $gateway )
        {
        }

        public function processRequest( string $method, ?string $id ): void
        {
            if ( $id ) {
                $this -> processResourceRequest( $method, $id );

            } else {
                $this -> processCollectionRequest( $method );
                
            }
        }

        private function processResourceRequest( string $method, string $id ): void
        {
            // $product = $this->gateway->get($id);
            
            // if ( ! $product) {
            //     http_response_code(404);
            //     echo json_encode(["message" => "Product not found"]);
            //     return;
            // }
            
            // switch ($method) {
            //     case "GET":
            //         echo json_encode($product);
            //         break;
                    
            //     case "PATCH":
            //         $data = (array) json_decode(file_get_contents("php://input"), true);
                    
            //         $errors = $this->getValidationErrors($data, false);
                    
            //         if ( ! empty($errors)) {
            //             http_response_code(422);
            //             echo json_encode(["errors" => $errors]);
            //             break;
            //         }
                    
            //         $rows = $this->gateway->update($product, $data);
                    
            //         echo json_encode([
            //             "message" => "Product $id updated",
            //             "rows" => $rows
            //         ]);
            //         break;
                    
            //     case "DELETE":
            //         $rows = $this->gateway->delete($id);
                    
            //         echo json_encode([
            //             "message" => "Product $id deleted",
            //             "rows" => $rows
            //         ]);
            //         break;
                    
            //     default:
            //         http_response_code(405);
            //         header("Allow: GET, PATCH, DELETE");
            // }
        }
        
        private function processCollectionRequest( string $method ): void
        {
            switch ( $method ) {
                case "GET":
                    // echo json_encode( $this-> gateway -> getAll() );
                    echo json_encode( mb_convert_encoding( $this-> gateway -> getAll(), 'UTF-8', 'UTF-8'), JSON_THROW_ON_ERROR );
                    break;
                    
                case "POST":
                    // $data = ( array ) json_decode( file_get_contents( "php://input" ), true );
                    
                    // $errors = $this->getValidationErrors($data);
                    
                    // if ( ! empty($errors)) {
                    //     http_response_code(422);
                    //     echo json_encode(["errors" => $errors]);
                    //     break;
                    // }
                    
                    // $id = $this -> gateway -> create( $data );
                    
                    // http_response_code( 201 );
                    // echo json_encode([
                    //     "message" => "Product created",
                    //     "id" => $id
                    // ]);

                    // if ( $_FILES[ 'upload' ]) {
                    //     $file_ary = reArrayFiles( $_FILES[ 'ufile' ]);
                    
                    //     foreach ($file_ary as $file) {
                    //         print 'File Name: ' . $file['name'];
                    //         print 'File Type: ' . $file['type'];
                    //         print 'File Size: ' . $file['size'];
                    //     }
                    // }

                    // echo $_FILES[ 'upfile' ][ 'name' ];
                    // echo " ";
                    // echo $_FILES[ 'upfile' ][ 'type' ];
                    // echo " ";
                    // echo $_FILES[ 'upfile' ][ 'size' ];

                    // Rearrange Files
                    // if ( $_FILES[ 'upfile' ]) {
                    //     $file_ary = $this -> reArrayFiles( $_FILES[ 'upfile' ]);
    
                    //     foreach ( $file_ary as $file ) {
                    //         echo $file[ 'name' ];
                    //         echo " ";
                    //         echo $file[ 'type' ];
                    //         echo " ";
                    //         echo $file[ 'size' ];
                    //     }
                    // }

                    // Undefined | Multiple Files | $_FILES Corruption Attack
                    // If this request falls under any of them, treat it invalid.
                    if (
                        !isset( $_FILES[ 'upfile' ][ 'error' ]) ||
                        is_array( $_FILES[ 'upfile' ][ 'error' ])
                    ) {
                        throw new RuntimeException( 'Invalid parameters.' );
                    }
                
                    // Check $_FILES['upfile']['error'] value.
                    switch ( $_FILES[ 'upfile' ][ 'error' ]) {
                        case UPLOAD_ERR_OK:
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            throw new RuntimeException( 'No file sent.' );
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            throw new RuntimeException( 'Exceeded filesize limit.' );
                        default:
                            throw new RuntimeException( 'Unknown errors.' );
                    }
                
                    // You should also check filesize here. 
                    if ( $_FILES[ 'upfile' ][ 'size' ] > 1000000000) {
                        throw new RuntimeException( 'Exceeded filesize limit.' );
                    }
                
                    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
                    // Check MIME Type by yourself.
                    $finfo = new finfo( FILEINFO_MIME_TYPE );
                    if ( false === $ext = array_search(
                        $finfo -> file( $_FILES[ 'upfile' ][ 'tmp_name' ]),
                        array(
                            'jpg' => 'image/jpeg',
                            'png' => 'image/png',
                            'gif' => 'image/gif',
                            'pdf' => 'application/pdf',
                        ),
                        true
                    )) {
                        throw new RuntimeException( 'Invalid file format.' );
                    }
                
                    // You should name it uniquely.
                    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                    // On this example, obtain safe unique name from its binary data.
                    if ( $_FILES[ 'upfile' ]
                        

                        // $id = $this -> gateway -> create( $data );
                    ) {
                        // if ( is_uploaded_file( $_FILES[ 'upfile' ][ 'tmp_name' ])) {
                        //     $fileData = file_get_contents( $_FILES[ 'upfile' ][ 'tmp_name' ]);
                        //     $fileType = $_FILES[ 'upfile' ][ 'type' ];
                        //     $sql = "INSERT INTO tbl_image(imageType ,imageData) VALUES(?, ?)";
                        //     $statement = $conn->prepare($sql);
                        //     $statement->bind_param('ss', $imgType, $imgData);
                        //     $current_id = $statement->execute() or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_connect_error());
                        // }

                        // 
                        $data = ( array ) $_FILES[ 'upfile' ];
                        // $fileName = $_FILES[ 'upfile' ]["name"]; 
                        // move_uploaded_file( $_FILES[ 'upfile' ][ 'tmp_name' ],'uploads/'.$fileName );
                        // echo json_encode( $data );
                        // var_dump( $data[ "filename" ] );

                        // foreach ( $data as $file ) { 

                        //     echo json_encode( $file );
                        // }

                        if ( is_uploaded_file( $_FILES[ 'upfile' ][ 'tmp_name' ])) {
                            $id = $this -> gateway -> create( $data );

                            http_response_code(201);
                            echo json_encode([
                                "message" => "File is uploaded successfully.",
                                "id" => $id
                            ]);
                        }
                        
                        else {
                            throw new RuntimeException( 'Failed to move uploaded file.' );
                        }
                
                    }
                    
                    else {
                        throw new RuntimeException( 'Failed to move uploaded file.' );
                    }
                    break;
                
                // default:
                //     http_response_code( 405 );
                //     header( "Allow: GET, POST" );
            }
        }
        
        private function getValidationErrors(array $data, bool $is_new = true): array
        {
            // $errors = [];
            
            // if ($is_new && empty($data["name"])) {
            //     $errors[] = "name is required";
            // }
            
            // if (array_key_exists("size", $data)) {
            //     if (filter_var($data["size"], FILTER_VALIDATE_INT) === false) {
            //         $errors[] = "size must be an integer";
            //     }
            // }
            
            // return $errors;
        }

        // Rearrange Files
        // private function reArrayFiles( &$file_post ){
        //     $isMulti    = is_array( $file_post[ 'name' ]);
        //     $file_count    = $isMulti ? count( $file_post[ 'name' ]) : 1;
        //     $file_keys    = array_keys( $file_post );
        
        //     $file_ary    = [];
        //     for( $i=0; $i < $file_count; $i++ )
        //         foreach( $file_keys as $key )
        //             if( $isMulti )
        //                 $file_ary[ $i ][ $key ] = $file_post[ $key ][ $i ];
        //             else
        //                 $file_ary[ $i ][ $key ]    = $file_post[ $key ];
        
        //     return $file_ary;
        // }
    }
?>

