<?php

namespace App\Mail;

use App\Models\Cart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orderItems,
        $name,
        $email,
        $phone,
        $address,
        $payment_method;

    /**
     * Create a new message instance.
     */




    public function __construct(
        $orderItems,
        $name,
        $email,
        $phone,
        $address,
        $payment_method,
    ) {
        $this->orderItems = $orderItems;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->payment_method = $payment_method;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Apcake',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'frontend.pages.checkout.mailcheckout',
            with: [
                'orderItems' => $this->orderItems,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'payment_method' => $this->payment_method,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
