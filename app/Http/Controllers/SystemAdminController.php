<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\Customer;
use App\Models\SupportStaff;
use App\Models\Category;
use App\Models\PriorityLevel;
use App\Models\Submission;

class SystemAdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $customersCount = Customer::count();
        $staffCount = SupportStaff::count();
        $submissionsCount = Submission::count();

        return view('admin.dashboard', compact('customersCount', 'staffCount', 'submissionsCount'));
    }

    // ===================== CUSTOMERS =====================
    public function listCustomers()
{
    $customers = Customer::all();
    return view('admin.customers.index', compact('customers'));
}

public function createCustomer()
{
    return view('admin.customers.create');
}

public function storeCustomer(Request $request)
{
    $request->validate([
        'Fname' => 'required|string|max:255',
        'Lname' => 'required|string|max:255',
        'email' => 'required|email|unique:customer,email',
        'password' => 'required|string|min:6',
        'contact_no' => 'required|string|max:20',
        'address' => 'required|string|max:255',
    ]);

    Customer::create([
        'Fname' => $request->Fname,
        'Lname' => $request->Lname,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'contact_no' => $request->contact_no,
        'address' => $request->address,
    ]);

    return redirect()->route('admin.customers')->with('success', 'Customer created successfully.');
}

public function editCustomer($id)
{
    $customer = Customer::findOrFail($id);
    return view('admin.customers.edit', compact('customer'));
}

public function updateCustomer(Request $request, $id)
{
    $customer = Customer::findOrFail($id);

    $request->validate([
        'Fname' => 'required|string|max:255',
        'Lname' => 'required|string|max:255',
        'email' => 'required|email|unique:customer,email,' . $customer->CustomerID . ',CustomerID',
        'contact_no' => 'required|string|max:20',
        'address' => 'required|string|max:255',
    ]);

    $customer->update([
        'Fname' => $request->Fname,
        'Lname' => $request->Lname,
        'email' => $request->email,
        'contact_no' => $request->contact_no,
        'address' => $request->address,
    ]);

    if ($request->password) {
        $customer->update(['password' => Hash::make($request->password)]);
    }

    return redirect()->route('admin.customers')->with('success', 'Customer updated successfully.');
}

public function deleteCustomer($id)
{
    Customer::findOrFail($id)->delete();
    return redirect()->route('admin.customers')->with('success', 'Customer deleted successfully.');
}

    // ===================== STAFF =====================
    public function listStaff()
{
    $staff = SupportStaff::all();
    return view('admin.staff.index', compact('staff'));
}

public function createStaff()
{
    return view('admin.staff.create');
}

public function storeStaff(Request $request)
{
    $request->validate([
        'Fname' => 'required|string|max:255',
        'Lname' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'contact_no' => 'required|string|max:20',
        'email' => 'required|email|unique:support_staff,email',
        'password' => 'required|string|min:6',
    ]);

    SupportStaff::create([
        'Fname' => $request->Fname,
        'Lname' => $request->Lname,
        'address' => $request->address,
        'contact_no' => $request->contact_no,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.staff')->with('success', 'Staff created successfully.');
}

public function editStaff($id)
{
    $staff = SupportStaff::findOrFail($id);
    return view('admin.staff.edit', compact('staff'));
}

public function updateStaff(Request $request, $id)
{
    $staff = SupportStaff::findOrFail($id);

    $request->validate([
        'Fname' => 'required|string|max:255',
        'Lname' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'contact_no' => 'required|string|max:20',
        'email' => 'required|email|unique:support_staff,email,' . $staff->StaffID . ',StaffID',
    ]);

    $staff->update([
        'Fname' => $request->Fname,
        'Lname' => $request->Lname,
        'address' => $request->address,
        'contact_no' => $request->contact_no,
        'email' => $request->email,
    ]);

    if ($request->password) {
        $staff->update(['password' => Hash::make($request->password)]);
    }

    return redirect()->route('admin.staff')->with('success', 'Staff updated successfully.');
}

public function deleteStaff($id)
{
    SupportStaff::findOrFail($id)->delete();
    return redirect()->route('admin.staff')->with('success', 'Staff deleted successfully.');
}

    // ===================== CATEGORIES =====================
    public function listCategories()
{
    $categories = Category::all();
    return view('admin.categories.index', compact('categories'));
}

public function createCategory()
{
    return view('admin.categories.create');
}

public function storeCategory(Request $request)
{
    $request->validate([
        'categoryname' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
    ]);

    Category::create([
        'categoryname' => $request->categoryname,
        'description' => $request->description,
    ]);

    return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
}

public function editCategory($id)
{
    $category = Category::findOrFail($id);
    return view('admin.categories.edit', compact('category'));
}

public function updateCategory(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $request->validate([
        'categoryname' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
    ]);

    $category->update([
        'categoryname' => $request->categoryname,
        'description' => $request->description,
    ]);

    return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
}

public function deleteCategory($id)
{
    Category::findOrFail($id)->delete();
    
    return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
}
    // ===================== PRIORITIES =====================
    public function listPriorities()
    {
        $priorities = PriorityLevel::all();
        return view('admin.priorities.index', compact('priorities'));
    }

    public function createPriority()
    {
        return view('admin.priorities.create');
    }

    public function storePriority(Request $request)
    {
        $request->validate([
            'priorityname' => 'required|string|max:255',
            'responsetime' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        PriorityLevel::create([
            'priorityname' => $request->priorityname,
            'responsetime' => $request ->responsetime,
            'description' => $request ->description,
        ]);

        return redirect()->route('admin.priorities')->with('success', 'Priority Level Created.');
    }

    public function editPriority($id)
    {
        $priorities = PriorityLevel::findOrFail($id);
        return view('admin.priorities.edit', compact('priorities'));
    }

    public function updatePriority(Request $request, $id)
    {
        $priorities = PriorityLevel::findOrFail($id);

        $request->validate([
            'priorityname' => 'required|string|max:255',
            'responsetime' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $priorities->update([
            'priorityname' => $request->priorityname,
            'responsetime' => $request->responsetime,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.priorities')->with('success', 'Priority Level Updated.');
    }

    public function deletePriority($id)
    {
        PriorityLevel::findOrFail($id)->delete();
        return redirect()->route('admin.priorities')->with('success', 'Priority Deleted.');
    }

    // ===================== SUBMISSIONS =====================
    public function listDeletedSubmissions()
{
    $submissions = Submission::with([
        'customer', 
        'category', 
        'priority', 
        'staff'
        ])
        ->where('is_deleted', true)
        ->orderBy('dateSubmitted', 'desc')
        ->get();

    return view('admin.submission.index', compact('submissions'));
}

public function restoreSubmission($id)
{
    $submission = Submission::findOrFail($id);
    $submission->is_deleted = false;
    $submission->status = 'Pending';
    $submission->save();

    return redirect()->route('admin.submissions')->with('success', 'Submission restored successfully.');
}

public function forceDeleteSubmission($id)
{
    $submission = Submission::findOrFail($id);
    $submission->comments()->delete();
    $submission->delete();

    return redirect()->route('admin.submissions')->with('success', 'Submission permanently deleted.');
}

}
