<?php
namespace app\repositories\booking;

interface RepositoryInterface
{
    public function get($id);

    public function add(Booking $booking);
}