<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
class ReservationController extends Controller
{
    public function create()
    {
        // Trang form đặt bàn của khách
        return view('customer.reservations.create');
    }

    public function store(StoreReservationRequest $request)
{
    $validated = $request->validated();

    $dt = Carbon::parse($validated['reservation_time']);

    $data = [
        'user_id'             => Auth::check() ? Auth::id() : null, // nếu đang login thì gán user
        'customer_name'       => $validated['customer_name'],
        'customer_phone'      => $validated['customer_phone'],
        'restaurant_table_id' => null,
        'reservation_date'    => $dt->toDateString(),
        'reservation_time'    => $dt->format('H:i:s'),
        'guest_count'         => $validated['num_guests'],
        'status'              => 'pending',
        'special_requests'    => $validated['special_requests'] ?? null,
    ];

    $reservation = Reservation::create($data);

    return redirect()->route('reservations.success', $reservation->id);
}

    public function showSuccess($id)
    {
        $reservation = Reservation::with(['user', 'restaurantTable'])->findOrFail($id);

        return view('customer.reservations.success', compact('reservation'));
    }

  public function history(Request $request)
{
    abort_unless(Auth::check(), 403);

    $query = Reservation::where('user_id', Auth::id());

    // Lọc theo mã đơn (id)
    if ($request->filled('code')) {
        $code = ltrim($request->input('code'), '#'); // nếu user nhập #123
        $query->where('id', $code);
    }

    // Lọc theo trạng thái
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    // Lọc theo ngày từ
    if ($request->filled('date_from')) {
        $query->whereDate('reservation_date', '>=', $request->input('date_from'));
    }

    // Lọc theo ngày đến
    if ($request->filled('date_to')) {
        $query->whereDate('reservation_date', '<=', $request->input('date_to'));
    }

    $reservations = $query
        ->orderByDesc('reservation_date')
        ->orderByDesc('reservation_time')
        ->get();

    // Trả thêm filters để view hiển thị lại giá trị đang chọn
    $filters = $request->only(['code', 'status', 'date_from', 'date_to']);

    return view('customer.reservations.history', compact('reservations', 'filters'));
}
}
