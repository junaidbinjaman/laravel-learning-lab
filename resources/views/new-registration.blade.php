<x-layout>
    <div class="flex items-center justify-center h-screen bg-gray-50">
        <div class="w-1/3 shadow-md rounded-lg p-5 bg-white">
            <h2>New Login Form</h2>
            <form>
                <p>
                    <label>Username</label>
                    <input name="username" type="text"
                           class="py-2 px-2 outline outline-blue-400 rounded-lg w-full text-lg">
                </p>
                <p>
                    <label>Email</label>
                    <input name="email" type="text"
                           class="py-2 px-2 outline outline-blue-400 rounded-lg w-full text-lg">
                </p>
                <p>
                    <label>Password</label>
                    <input name="password" type="password"
                           class="py-2 px-2 outline outline-blue-400 rounded-lg w-full text-lg">
                </p>
                <input
                    type="submit"
                    value="Submit"
                    class="text-lg bg-blue-400 py-3 px-5 text-white font-bold rounded-lg cursor-pointer transition-all active:scale-75"
                />
            </form>
        </div>
    </div>
</x-layout>
