<?php

namespace App\Enums;

enum OrderStatusesEnum: string
{

    use BaseEnum;

    case NEW = 'new'; // новий
    case IN_PROCESS = 'inProcess'; // в обробці
    case SENT = 'sent'; // відправлений
    case DELIVERED = 'delivered'; // доставлений

}
