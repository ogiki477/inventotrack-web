<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StockRecordChangeNotification extends Notification
{
    use Queueable;

    protected $action;
    protected $item;


    public function __construct($action, $item)
    {
        $this->action = $action;
        $this->item = $item;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable){
        $categoryName = $this->item->stockCategory ? $this->item->stockCategory->name : 'Unknown Category';
        $subCategoryName = $this->item->stockSubCategory ? $this->item->stockSubCategory->name : 'Unknown Subcategory';
        $financialPeriod = $this->item->financialPeriod ? $this->item->financialPeriod->name : 'Unknown Financial Period';
        $companyName = $this->item->company ? $this->item->company->name : 'Unknown Company';

        return (new MailMessage)
            ->subject('Stock Record ' . ucfirst($this->action))
            ->line('A stock record has been ' . $this->action . '.')
            ->line('Details are below:')
            ->line('Name: ' . $this->item->name)
            ->line('SKU: ' . $this->item->sku)
            ->line('Description: ' . $this->item->description)
            ->line('Stock Category: ' . $categoryName)
            ->line('Stock Subcategory: ' . $subCategoryName)
            ->line('Financial Period: ' . $financialPeriod)
            ->line('Company: ' . $companyName)
            ->line('Type: ' . $this->item->type);

    }

  
}
