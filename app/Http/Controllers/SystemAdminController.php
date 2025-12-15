<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\SupportStaff;
use App\Models\Category;
use App\Models\PriorityLevel;
use App\Models\Submission;

class SystemAdminController extends Controller
{
    // Display admin dashboard with total counts
    public function dashboard()
    {
        $customersCount = Customer::count();
        $staffCount = SupportStaff::count();
        $submissionsCount = Submission::count();

        return view('admin.dashboard', compact('customersCount', 'staffCount', 'submissionsCount'));
    }

    // List all customers
    public function listCustomers()
    {
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    // Show create customer form
    public function createCustomer()
    {
        return view('admin.customers.create');
    }

    // Store new customer
    public function storeCustomer(Request $request)
    {
        $request->validate([
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'email' => 'required|email|unique:customer,email',
            'password' => 'required|string|min:8|confirmed',
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

    // Show edit customer form
    public function editCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    // Update customer
    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'email' => 'required|email|unique:customer,email,' . $customer->CustomerID . ',CustomerID',
            'contact_no' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
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

    // Delete customer
    public function deleteCustomer($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('admin.customers')->with('success', 'Customer deleted successfully.');
    }

    // List all staff
    public function listStaff()
    {
        $staff = SupportStaff::all();
        return view('admin.staff.index', compact('staff'));
    }

    // Show create staff form
    public function createStaff()
    {
        return view('admin.staff.create');
    }

    // Store new staff
    public function storeStaff(Request $request)
    {
        $request->validate([
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
            'email' => 'required|email|unique:support_staff,email',
            'password' => 'required|string|min:8|confirmed',
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

    // Show edit staff form
    public function editStaff($id)
    {
        $staff = SupportStaff::findOrFail($id);
        return view('admin.staff.edit', compact('staff'));
    }

    // Update staff
    public function updateStaff(Request $request, $id)
    {
        $staff = SupportStaff::findOrFail($id);

        $request->validate([
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
            'email' => 'required|email|unique:support_staff,email,' . $staff->StaffID . ',StaffID',
            'password' => 'nullable|string|min:8|confirmed',
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

    // Delete staff
    public function deleteStaff($id)
    {
        SupportStaff::findOrFail($id)->delete();
        return redirect()->route('admin.staff')->with('success', 'Staff deleted successfully.');
    }

    // List all categories
    public function listCategories()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Show create category form
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    // Store new category
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

    // Show edit category form
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Update category
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

    // Delete category
    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }

    // List all priority levels
    public function listPriorities()
    {
        $priorities = PriorityLevel::all();
        return view('admin.priorities.index', compact('priorities'));
    }

    // Show create priority form
    public function createPriority()
    {
        return view('admin.priorities.create');
    }

    // Store new priority level
    public function storePriority(Request $request)
    {
        $request->validate([
            'priorityname' => 'required|string|max:255',
            'responsetime' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        PriorityLevel::create([
            'priorityname' => $request->priorityname,
            'responsetime' => $request->responsetime,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.priorities')->with('success', 'Priority Level Created.');
    }

    // Show edit priority form
    public function editPriority($id)
    {
        $priorities = PriorityLevel::findOrFail($id);
        return view('admin.priorities.edit', compact('priorities'));
    }

    // Update priority level
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

    // Delete priority level
    public function deletePriority($id)
    {
        PriorityLevel::findOrFail($id)->delete();
        return redirect()->route('admin.priorities')->with('success', 'Priority Deleted.');
    }

    // List all soft-deleted submissions
    public function listDeletedSubmissions()
    {
        $submissions = Submission::with(['customer', 'category', 'priority', 'staff'])
            ->where('is_deleted', true)
            ->orderBy('dateSubmitted', 'desc')
            ->get();

        return view('admin.submission.index', compact('submissions'));
    }

    // Restore a soft-deleted submission
    public function restoreSubmission($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->is_deleted = false;
        $submission->status = 'Pending';
        $submission->save();

        return redirect()->route('admin.submissions')->with('success', 'Submission restored successfully.');
    }

    // Permanently delete a submission along with its comments
    public function forceDeleteSubmission($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->comments()->delete();
        $submission->delete();

        return redirect()->route('admin.submissions')->with('success', 'Submission permanently deleted.');
    }
}
