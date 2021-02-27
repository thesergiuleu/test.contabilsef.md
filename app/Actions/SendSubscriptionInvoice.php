<?php


namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class SendSubscriptionInvoice extends AbstractAction
{

    public function getTitle()
    {
        return 'Trimite factura';
    }

    public function getIcon()
    {
        return 'voyager-params';
    }

    public function getDefaultRoute()
    {
        return route('subscribe.send', $this->data->id);
    }


    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-info pull-right edit',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'subscriptions' && $this->data->payment_method == 'transfer';
    }
}
