<?php
// app/Services/PaymentService.php

namespace App\Services;

use App\Repositories\PaymentRepository;
use App\Models\Payment;
use Exception;

class PaymentService
{
    public function __construct(
        protected PaymentRepository $paymentRepository
    ) {}

    /**
     * Store a new payment.
     *
     * @param  array  $data
     * @return Payment
     */
    public function createPayment(array $data): Payment
    {
        try {
            // Create the payment using the repository
            return $this->paymentRepository->store($data);
        } catch (Exception $e) {
            // Handle exception if any error occurs
            throw new Exception("Error creating payment: " . $e->getMessage());
        }
    }

    /**
     * Get all payments.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPayments()
    {
        return $this->paymentRepository->all();
    }

    /**
     * Get a payment by ID.
     *
     * @param  string  $id
     * @return Payment|null
     */
    public function getPaymentById(string $id): ?Payment
    {
        return $this->paymentRepository->findById($id);
    }
}
