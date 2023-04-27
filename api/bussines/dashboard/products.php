<?php
//This url is to use data, of the atributes and queries through dependecies
require_once('../../enitites/dto/products.php');
//This if is to validate the action is to do
if (isset($_GET['action'])) {
    session_start();
    //Object to mecioned functions of the queries, through this object
    $product_model = new Product;
    //This variable is to show the answer at the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    //Is to verficate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Is to verificated that action is to do
        switch ($_GET['action']) {
            //This action is to charger datas in the table
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
            //This action is to show all valorations of the products
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
            //This action is to show the status of the product data in te select
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
            //This action is to search the especific data
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
            //This action is verificate the exists of the product
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
            //This action is to create a new product and verificate data to send at the queries file
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
            //This action is to update a product and verificate data to send at the queries file
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
            //This action is to delete data of the product
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
            //This action is to delete data of the product valoration
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
        //indicate the tyoe of the content to show and yours respective strings
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