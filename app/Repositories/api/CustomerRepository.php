<?php

namespace App\Repositories\api;

use App\Exceptions\GeneralException;
use App\Models\Customer;
use App\Models\Role;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class CustomerRepository extends BaseRepository
{
    public function model()
    {
        return Customer::class;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            //get user
            $user = auth()->user();
            //check if a customer already existed
            $customer = Customer::where('user_id', $user->id)->first();
            if ($customer) {
                throw new GeneralException('already existed');
            }
            //create a new customer
            $customer = parent::create([
                'id' => $user->id,
                'user_id' => $user->id,
                'trade_name' => $data['trade_name'],
                'business_name' => $data['business_name'],
                'street' => $data['street'],
                'province' => $data['province'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'about' => $data['about'],
            ]);
            if ($customer) {
                $user->update([
                    'account_type' => 'customer',
                    'role_id' => Role::getRole('Customer'),
                ]);

                return $customer;
            }
            throw new GeneralException(__('error'));
        });
    }

    public function update(Customer $customer, array $data)
    {
        return DB::transaction(function () use ($customer, $data) {
            if ($customer->update([
                'trade_name' => $data['trade_name'] !== null ? $data['trade_name'] : $customer->trade_name,
                'business_name' => $data['business_name'] !== null ? $data['business_name'] : $customer->trade_name,
                'street' => $data['street'] !== null ? $data['street'] : $customer->street,
                'province' => $data['province'] !== null ? $data['province'] : $customer->province,
                'city' => $data['city'] !== null ? $data['city'] : $customer->city,
                'postal_code' => $data['postal_code'] !== null ? $data['postal_code'] : $customer->postal_code,
                'phone' => $data['phone'] !== null ? $data['phone'] : $customer->phone,
                'email' => $data['email'] !== null ? $data['email'] : $customer->email,
                'about' => $data['about'] !== null ? $data['about'] : $customer->about,
            ])) {
                return $customer;
            }
            throw new GeneralException('error');
        });
    }

    public function updateImage(Customer $customer, array $data)
    {
        return DB::transaction(function () use ($customer, $data) {
            unlink(public_path('storage/'.$customer->image));
            if ($customer->update([
                'image' => $this->UploadImage($data['image'], auth()->user()->id),
            ])) {
                return $customer;
            }
            throw new GeneralException('error');
        });
    }

    // Upload image function
    public function UploadImage($image, $path)
    {
        //get file name with extention
        $filenameWithExt = $image->getClientOriginalName();
        //get just file name
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //GET EXTENTION
        $extention = $image->getClientOriginalExtension();
        //file name to store
        $fileNameToStore = '/images/customers/'.$path.'/'.$filename.'_'.time().'.'.$extention;
        //upload image
        $path = $image->storeAs('public/', $fileNameToStore);

        return $fileNameToStore;
    }
}
