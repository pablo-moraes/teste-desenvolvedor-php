import './bootstrap';

import '../sass/app.scss';

import { CRUDClient } from "./class/CRUDClient";
import { User } from "./class/user/auth/User";

export const ApiManager =  {};

ApiManager.general = new CRUDClient();
ApiManager.auth = new User();
