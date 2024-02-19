<?php
    header('Access-Control-Allow-Origin: *'); // Adjust this to match your actual domain, using '*' is less secure
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Adjust based on your needs
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization'); // Add any other headers you need to support
    header('Access-Control-Allow-Credentials: true'); // If you're handling cookies/session
    
    // Handle preflight request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        // Return only CORS headers for preflight
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) // May not be necessary depending on your server
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Adjust based on your needs
    
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        // No further action needed for preflight
        exit(0);
    }
    
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
                    // $image = file_get_contents( './files/test.jpeg' );
                    // header('Content-Type: image/jpeg');
                    // readfile( './files/test.jpeg' );
                    // echo base64_decode( './files/test.jpeg' );
                    // echo $image;
                    break;
                    
                case "POST":
                    // Undefined | Multiple Files | $_FILES Corruption Attack
                    // If this request falls under any of them, treat it invalid.
                    if (
                        !isset( $_FILES[ 'upfile' ][ 'error' ]) ||
                        is_array( $_FILES[ 'upfile' ][ 'error' ])
                    ) {
                        throw new RuntimeException( 'Invalid parameters!' );
                    }
                
                    // Check $_FILES['upfile']['error'] value.
                    switch ( $_FILES[ 'upfile' ][ 'error' ]) {
                        case UPLOAD_ERR_OK:
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            throw new RuntimeException( 'No file sent!' );
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            throw new RuntimeException( 'Exceeded filesize limit!' );
                        default:
                            throw new RuntimeException( 'Unknown errors!' );
                    }
                
                    // You should also check filesize here. 
                    if ( $_FILES[ 'upfile' ][ 'size' ] > 1000000000) {
                        throw new RuntimeException( 'Exceeded filesize limit!' );
                    }


                    // Upload File
                    if ( $_FILES[ 'upfile' ] ) {
                        $data = ( array ) $_FILES[ 'upfile' ];

                        if ( is_uploaded_file( $_FILES[ 'upfile' ][ 'tmp_name' ])) {
                            $id = $this -> gateway -> create( $data );

                            http_response_code(201);
                            echo json_encode([
                                "message" => "File is uploaded successfully!",
                                "id" => $id
                            ]);
                        }
                        
                        else {
                            throw new RuntimeException( 'Failed to move uploaded file!' );
                        }
                
                    }
                    
                    else {
                        throw new RuntimeException( 'Failed to move uploaded file!' );
                    }
                    break;
                
                default:
                    http_response_code( 405 );
                    header( "Allow: GET, POST" );
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
    }
?>

