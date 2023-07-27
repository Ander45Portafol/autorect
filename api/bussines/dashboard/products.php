<?php
//Dependencies
require_once('../../entities/dto/products.php');

//Validate what action is being done
if (isset($_GET['action'])) {
    session_start();
    //Object to mention the functions of the queries
    $product_model = new Product;
    //Variable to show the answer of the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    //Validate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Actions
        switch ($_GET['action']) {
                //Action to fill the table
            case 'readAll':
                if ($result['dataset'] = $product_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
                //Action to read all the valorations per product
            case 'readAllValoration':
                if (!$product_model->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Wrong product';
                } elseif ($result['dataset'] = $product_model->readAllValorations()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
                //Action to read all the status of the products
            case 'readStatus':
                if ($result['dataset'] = $product_model->readStatusProduct()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
                //Action to search for products
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $product_model->readAll();
                } elseif ($result['dataset'] = $product_model->searchRow($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
                //Action to read one product
            case 'readOne':
                if (!$product_model->setId($_POST['id'])) {
                    $result['exception'] = 'Wrong product';
                } elseif ($result['dataset'] = $product_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The category does not exist';
                }
                break;
                //Action to create a product
            case 'create':
                if (!$product_model->setProductName($_POST['Product_name'])) {
                    $result['exception'] = 'Wrong name';
                } elseif (!$product_model->setProductPrice($_POST['Price'])) {
                    $result['exception'] = 'Wrong product price';
                } elseif (!$product_model->setProductStock($_POST['Stock'])) {
                    $reuslt['exception'] = 'Something went wrong with the stock';
                } elseif (!$product_model->setProductCategory($_POST['Category'])) {
                    $result['exception'] = 'Select a category';
                } elseif (!$product_model->setProductModel($_POST['Model'])) {
                    $result['exception'] = 'Select a model';
                } elseif (!$product_model->setProductStatus($_POST['Status'])) {
                    $result['exception'] = 'Select an status for the product';
                } elseif (!$product_model->setProductDescription($_POST['product_description'])) {
                    $result['exception'] = 'Wrong description';
                } elseif (!$product_model->setProductImg($_FILES['imageProduct'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($product_model->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageProduct'], $product_model->getRoute(), $product_model->getProductImg())) {
                        $result['message'] = 'Product created successfully';
                    } else {
                        $result['message'] = 'Product created without image';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Action to update a product
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$product_model->setId($_POST['id'])) {
                    $reuslt['exception'] = 'Wrong employee';
                } elseif (!$data = $product_model->readOne()) {
                    $result['exception'] = 'The category does not exist';
                } elseif (!$product_model->setProductName($_POST['Product_name'])) {
                    $result['exception'] = 'Wrong name';
                } elseif (!$product_model->setProductPrice($_POST['Price'])) {
                    $result['exception'] = 'Wrong price';
                } elseif (!$product_model->setProductStock($_POST['NewStock'])) {
                    $reuslt['exception'] = 'No stock';
                } elseif (!$product_model->setProductCategory($_POST['Category'])) {
                    $result['exception'] = 'Select a category';
                } elseif (!$product_model->setProductModel($_POST['Model'])) {
                    $result['exception'] = 'Select a model';
                } elseif (!$product_model->setProductStatus($_POST['Status'])) {
                    $result['exception'] = 'Select a status';
                } elseif (!$product_model->setProductDescription($_POST['product_description'])) {
                    $result['exception'] = 'Wrong description';
                } elseif (!is_uploaded_file($_FILES['imageProduct']['tmp_name'])) {
                    if ($product_model->updateRow($data['imagen_principal'])) {
                        $result['status'] = 1;
                        $Result['message'] = 'The product was updated successfully';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$product_model->setProductImg($_FILES['imageProduct'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($product_model->updateRow($data['imagen_principal'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageProduct'], $product_model->getRoute(), $product_model->getProductImg())) {
                        $Result['message'] = 'The product was updated successfully';
                    } else {
                        $Result['message'] = 'The product was updated without image';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Action to delete a product
            case 'delete':
                if (!$product_model->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecta';
                } elseif (!$data = $product_model->readOne()) {
                    $result['exception'] = 'The product does not exist';
                } elseif ($product_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The product was deleted';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Actions to change the status of the valoration
            case 'FalseValoration':
                if (!$product_model->setValorationId($_POST['id_valoracion'])) {
                    $result['exception'] = 'Wrong valoration';
                } elseif (!$data = $product_model->readOneValoration()) {
                    $result['exception'] = 'The valoration does not exist';
                } elseif ($product_model->FalseValoration()) {
                    $result['status'] = 1;
                    $result['message'] = 'The valoration was deleted';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'TrueValoration':
                if (!$product_model->setValorationId($_POST['id_valoracion'])) {
                    $result['exception'] = 'Wrong valoration';
                } elseif (!$data = $product_model->readOneValoration()) {
                    $result['exception'] = 'The valoration does not exist';
                } elseif ($product_model->TrueValoration()) {
                    $result['status'] = 1;
                    $result['message'] = 'The valoration was deleted';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'cantidadUsuarios':
                if ($result['dataset'] = $product_model->cantidadUsuarios()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'cantidadModeloMarca':
                if ($result['dataset'] = $product_model->cantidadModelosMarcas()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'porcentajesPedidos':
                if ($result['dataset'] = $product_model->porcentajesPedidos()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'porcentajeClientes':
                if ($result['dataset'] = $product_model->porcentajesClientes()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'fechasPedidos':
                if ($result['dataset'] = $product_model->fechasPedidos()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                //Action to read the images per product
            case 'readImgs':
                if (!$product_model->setId($_POST['id_producto'])) {
                    $result['exception'] = 'The product does not exist';
                } elseif ($result['dataset'] = $product_model->readImgs()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'];
                }
                break;
                //Action to create an image asigned to a product
            case 'createImg':
                $num = $_POST['num'];
                if (!$product_model->setSImg($_FILES['input-img-' . $num])) {
                    $result['exception'] = Validator::getFileError('input-img-' . $num);
                } elseif (!$product_model->setId($_POST['id-p'])) {
                    $result['exception'] = 'The product does not exist';
                } elseif ($id = $product_model->createImg()) {
                    $result['status'] = 1;
                    $result['idimagen'] = $id;
                    if (Validator::saveFile($_FILES['input-img-' . $num], $product_model->getRoute(), $product_model->getSImg())) {
                        $result['message'] = 'The image was created';
                    } else {
                        $result['message'] = 'The image cant be created';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Action to delete an image
            case 'deleteImg':
                if (!$product_model->setImgId($_POST['id_imagen_producto'])) {
                    $result['exception'] = 'Wrong id';
                } elseif (!$data = $product_model->readOneImg()) {
                    $result['exception'] = 'The image does not exist';
                } elseif ($product_model->deleteImg()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($product_model->getRoute(), $data['nombre_archivo_imagen'])) {
                        $result['message'] = 'The image was deleted succesfully';
                    } else {
                        $result['message'] = 'The image was deleted, but still have it';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Case default if anything is executed
            default:
                $result['exception'] = 'The action can not be performed';
        }
        //Indicate the content type
        header('content-type: application/json; charset=utf-8');
        //Show the result in format JSON and return at the controller
        print(json_encode($result));
    } else {
        print(json_encode('Access denied'));
    }
} else {
    //If nothing are compilating, the api show this message in format JSON
    print(json_encode('File unavaliable'));
}
