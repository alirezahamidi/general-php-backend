<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: client-token,request-type');

$config = new \stdClass();
$config->db = new \stdClass();
$config->modules = new \stdClass();

//DB 
$config->db = new \stdClass();
$config->db->server = getenv("db_server");
$config->db->username = getenv("db_username");
$config->db->password = getenv("db_password");

$config->db->list = new \stdClass();
$config->db->list->shop = "shop";
$config->db->list->users = "users";
$config->db->list->blog = "blog";
$config->db->list->ordering = "ordering";
$config->db->list->commerical = "commerical";

$config->catch = new \stdClass();
$config->catch->userData = "";

$config->webBaseUrl = "http://www.programlearn.ir/";
$config->blogBaseUrl = "http://www.programlearn.ir/#/blog/";

$config->sitemap = json_decode("{}");
$config->sitemap->main = "app/resource/sitemap/sitemap.xml";
$config->sitemap->base = "app/resource/sitemap/sitemap_base.xml";

//Requests
$config->modules = new \stdClass();
$config->modules->login = new \stdClass();
$config->modules->products = new \stdClass();
$config->modules->products_categories = new \stdClass();
$config->modules->users = new \stdClass();

// Login
$config->modules->login->access = new \stdClass();
$config->modules->login->access->min = 96;

//____ Login Actions
$config->modules->login->actions = new \stdClass();

$config->modules->login->actions->login = new \stdClass();
$config->modules->login->actions->login->access = 91;

$config->modules->login->actions->signupUser = new \stdClass();
$config->modules->login->actions->signupUser->access = 91;

$config->modules->login->actions->checkToken = new \stdClass();
$config->modules->login->actions->checkToken->access = 91;

// products
$config->modules->products = new \stdClass();
$config->modules->products->access = new \stdClass();
$config->modules->products->access->min = 79;
//____ products Actions
$config->modules->products->actions = new \stdClass();

$config->modules->products->actions->listAll = new \stdClass();
$config->modules->products->actions->listAll->access = 79;

$config->modules->products->actions->addProduct = new \stdClass();
$config->modules->products->actions->addProduct->access = 25;

$config->modules->products->actions->delete = new \stdClass();
$config->modules->products->actions->delete->access = 25;

$config->modules->products->actions->getProduct = new \stdClass();
$config->modules->products->actions->getProduct->access = 79;

$config->modules->products->actions->updateProduct = new \stdClass();
$config->modules->products->actions->updateProduct->access = 25;

$config->modules->products->actions->getSale = new \stdClass();
$config->modules->products->actions->getSale->access = 25;

$config->modules->products->actions->saveSale = new \stdClass();
$config->modules->products->actions->saveSale->access = 25;

$config->modules->products->actions->getPrice = new \stdClass();
$config->modules->products->actions->getPrice->access = 79;

$config->modules->products->actions->getProductsDetiles = new \stdClass();
$config->modules->products->actions->getProductsDetiles->access = 79;


// contents
$config->modules->contents = new \stdClass();
$config->modules->contents->access = new \stdClass();
$config->modules->contents->access->min = 79;
//____ contents Actions
$config->modules->contents->actions = new \stdClass();

$config->modules->contents->actions->listAll = new \stdClass();
$config->modules->contents->actions->listAll->access = 79;

$config->modules->contents->actions->addContent = new \stdClass();
$config->modules->contents->actions->addContent->access = 25;

$config->modules->contents->actions->delete = new \stdClass();
$config->modules->contents->actions->delete->access = 25;

$config->modules->contents->actions->getContent = new \stdClass();
$config->modules->contents->actions->getContent->access = 79;

$config->modules->contents->actions->updateContent = new \stdClass();
$config->modules->contents->actions->updateContent->access = 25;

$config->modules->contents->actions->getContentsDetiles = new \stdClass();
$config->modules->contents->actions->getContentsDetiles->access = 79;

$config->modules->contents->actions->getStatics = new \stdClass();
$config->modules->contents->actions->getStatics->access = 79;

//____ Comments
$config->modules->comments = new \stdClass();
$config->modules->comments->access = new \stdClass();
$config->modules->comments->access->min = 79;
//____ Comments Actions
$config->modules->comments->actions = new \stdClass();

$config->modules->comments->actions->addComment = new \stdClass();
$config->modules->comments->actions->addComment->access = 79;

// products_categories
$config->modules->products_categories = new \stdClass();
$config->modules->products_categories->access = new \stdClass();
$config->modules->products_categories->access->min = 79;
//____ products_categories Actions
$config->modules->products_categories->actions = new \stdClass();

$config->modules->products_categories->actions->changeStatus = new \stdClass();
$config->modules->products_categories->actions->changeStatus->access = 79;

$config->modules->products_categories->actions->addNew = new \stdClass();
$config->modules->products_categories->actions->addNew->access = 79;

$config->modules->products_categories->actions->edit = new \stdClass();
$config->modules->products_categories->actions->edit->access = 79;

$config->modules->products_categories->actions->delete = new \stdClass();
$config->modules->products_categories->actions->delete->access = 79;

$config->modules->products_categories->actions->listAll = new \stdClass();
$config->modules->products_categories->actions->listAll->access = 79;

$config->modules->products_categories->actions->getAll = new \stdClass();
$config->modules->products_categories->actions->getAll->access = 79;

$config->modules->products_categories->actions->allMenusList = new \stdClass();
$config->modules->products_categories->actions->allMenusList->access = 79;

$config->modules->products_categories->actions->getCateory = new \stdClass();
$config->modules->products_categories->actions->getCateory->access = 79;

//contents_categories
$config->modules->contents_categories = new \stdClass();
$config->modules->contents_categories->access = new \stdClass();
$config->modules->contents_categories->access->min = 79;
//____ contents_categories Actions
$config->modules->contents_categories->actions = new \stdClass();

$config->modules->contents_categories->actions->changeStatus = new \stdClass();
$config->modules->contents_categories->actions->changeStatus->access = 79;

$config->modules->contents_categories->actions->addNew = new \stdClass();
$config->modules->contents_categories->actions->addNew->access = 79;

$config->modules->contents_categories->actions->edit = new \stdClass();
$config->modules->contents_categories->actions->edit->access = 79;

$config->modules->contents_categories->actions->delete = new \stdClass();
$config->modules->contents_categories->actions->delete->access = 79;

$config->modules->contents_categories->actions->listAll = new \stdClass();
$config->modules->contents_categories->actions->listAll->access = 79;

$config->modules->contents_categories->actions->getAll = new \stdClass();
$config->modules->contents_categories->actions->getAll->access = 79;

$config->modules->contents_categories->actions->allMenusList = new \stdClass();
$config->modules->contents_categories->actions->allMenusList->access = 79;

$config->modules->contents_categories->actions->getCateory = new \stdClass();
$config->modules->contents_categories->actions->getCateory->access = 79;


// users    
$config->modules->users = new \stdClass();
$config->modules->users->access = new \stdClass();
$config->modules->users->access->min = 35;
//____ users Actions
$config->modules->users->actions = new \stdClass();

$config->modules->users->actions->listAll = new \stdClass();
$config->modules->users->actions->listAll->access = 21;

$config->modules->users->actions->deleteUser = new \stdClass();
$config->modules->users->actions->deleteUser->access = 21;

$config->modules->users->actions->editUser = new \stdClass();
$config->modules->users->actions->editUser->access = 21;

$config->modules->users->actions->getUserInfo = new \stdClass();
$config->modules->users->actions->getUserInfo->access = 35;

$config->modules->users->actions->getUserProfile = new \stdClass();
$config->modules->users->actions->getUserProfile->access = 35;




// settings    
$config->modules->settings = new \stdClass();
$config->modules->settings->access = new \stdClass();
$config->modules->settings->access->min = 14;
//____ settings Actions
$config->modules->settings->actions = new \stdClass();

$config->modules->settings->actions->get = new \stdClass();
$config->modules->settings->actions->get->access = 14;

$config->modules->settings->actions->save = new \stdClass();
$config->modules->settings->actions->save->access = 14;


// shipping    
$config->modules->shipping = new \stdClass();
$config->modules->shipping->access = new \stdClass();
$config->modules->shipping->access->min = 94;
//____ shipping Actions
$config->modules->shipping->actions = new \stdClass();

$config->modules->shipping->actions->addToBasket = new \stdClass();
$config->modules->shipping->actions->addToBasket->access = 51;

$config->modules->shipping->actions->removeFromBasket = new \stdClass();
$config->modules->shipping->actions->removeFromBasket->access = 51;

$config->modules->shipping->actions->getBasket = new \stdClass();
$config->modules->shipping->actions->getBasket->access = 51;

$config->modules->shipping->actions->isBought = new \stdClass();
$config->modules->shipping->actions->isBought->access = 51;

$config->modules->shipping->actions->pay = new \stdClass();
$config->modules->shipping->actions->pay->access = 51;


// shipping    
$config->modules->mail = new \stdClass();
$config->modules->mail->access = new \stdClass();
$config->modules->mail->access->min = 11;
//____ shipping Actions
$config->modules->mail->actions = new \stdClass();

$config->modules->mail->actions->sendEMail = new \stdClass();
$config->modules->mail->actions->sendEMail->access = 11;



// commerical_parts    
$config->modules->commerical_parts = new \stdClass();
$config->modules->commerical_parts->access = new \stdClass();
$config->modules->commerical_parts->access->min = 89;
//____ commerical_parts Actions
$config->modules->commerical_parts->actions = new \stdClass();

$config->modules->commerical_parts->actions->listAll = new \stdClass();
$config->modules->commerical_parts->actions->listAll->access = 12;

$config->modules->commerical_parts->actions->get = new \stdClass();
$config->modules->commerical_parts->actions->get->access = 12;

$config->modules->commerical_parts->actions->add = new \stdClass();
$config->modules->commerical_parts->actions->add->access = 12;

$config->modules->commerical_parts->actions->edit = new \stdClass();
$config->modules->commerical_parts->actions->edit->access = 12;

$config->modules->commerical_parts->actions->delete = new \stdClass();
$config->modules->commerical_parts->actions->delete->access = 12;

$config->modules->commerical_parts->actions->render = new \stdClass();
$config->modules->commerical_parts->actions->render->access = 89;



// commerical_parts    
$config->modules->commerical_ordering = new \stdClass();
$config->modules->commerical_ordering->access = new \stdClass();
$config->modules->commerical_ordering->access->min = 31;
//____ commerical_parts Actions
$config->modules->commerical_ordering->actions = new \stdClass();

$config->modules->commerical_ordering->actions->add = new \stdClass();
$config->modules->commerical_ordering->actions->add->access = 31;


// System Settings
$config->settings = new \stdClass();
$config->settings->login_expire = 20;

include 'access.php';
