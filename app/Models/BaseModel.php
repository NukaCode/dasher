<?php

namespace App\Models;

use NukaCode\Core\Models\BaseModel as CoreBaseModel;

abstract class BaseModel extends CoreBaseModel
{

    /********************************************************************
     * Core
     *******************************************************************/
    const ROLE_DEVELOPER = 2;
    const ROLE_GUEST = 3;
    const ROLE_FORUM_ADMIN = 5;
    const ROLE_SITE_ADMIN = 1;
}
