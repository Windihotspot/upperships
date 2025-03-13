<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import Header from "../components/Header.vue";

const activeForm = ref("login");

const currentForm = ref("login");

const toggleView = () => {
    currentForm.value = currentForm.value === "login" ? "register" : "login";
};

const isLogin = ref(true);
const showPassword = ref(false);

const loginForm = ref({
    email: "",
    password: "",
    remember: false,
    errors: {},
    processing: false,
});

const registerForm = ref({
    first_name: "",
    last_name: "",
    email: "",
    password: "",
    errors: {
        first_name: "",
        last_name: "",
        email: "",
        password: "",
    },
    processing: false,
});

const hasUppercase = computed(() => /[A-Z]/.test(registerForm.value.password));
const hasLowercase = computed(() => /[a-z]/.test(registerForm.value.password));
const hasNumber = computed(() => /[0-9]/.test(registerForm.value.password));
const hasSpecialChar = computed(() =>
    /[!@#$%^&*(),.?":{}|<>]/.test(registerForm.value.password)
);
</script>

<template>
    <Header/>
    <div class="flex min-h-screen bg-white">
        <!-- Right side with form -->
        <div
            class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8"
        >
            <Transition name="fade">
                <div :key="currentForm">
                    <!-- Login Form -->
                    <div
                        key="login"
                        v-if="activeForm === 'login'"
                        class="w-full max-w-md space-y-8"
                    >
                        <div class="text-center">
                            <!-- <img
                            src="/images/logo-icon.svg"
                            alt="Company logo"
                            class="mx-auto h-8 w-auto"
                        /> -->
                            <h2
                                class="mt-6 text-3xl font-bold tracking-tight text-gray-900"
                            >
                                Welcome back!
                            </h2>
                            <p class="mt-2 text-sm text-gray-600">
                                Provide your login credentials to access your
                                account
                            </p>
                        </div>

                        <form
                            @submit.prevent="submitLogin"
                            class="mt-8 space-y-6"
                        >
                            <div class="space-y-4">
                                <div>
                                    <label
                                        for="email"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Email Address
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            v-model="loginForm.email"
                                            type="email"
                                            id="email"
                                            required
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                            placeholder="johndoe@example.com"
                                        />
                                    </div>
                                    <InputError
                                        :message="loginForm.errors.email"
                                        class="mt-2"
                                    />
                                </div>

                                <div>
                                    <label
                                        for="password"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Password
                                    </label>
                                    <div class="relative mt-1">
                                        <input
                                            v-model="loginForm.password"
                                            :type="
                                                showPassword
                                                    ? 'text'
                                                    : 'password'
                                            "
                                            id="password"
                                            required
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                            placeholder="Enter password"
                                        />
                                        <button
                                            type="button"
                                            @click="
                                                showPassword = !showPassword
                                            "
                                            class="absolute inset-y-0 right-0 flex items-center pr-3"
                                        >
                                            <i
                                                :class="
                                                    showPassword
                                                        ? 'fas fa-eye-slash'
                                                        : 'fas fa-eye'
                                                "
                                                class="h-4 w-4 text-gray-800"
                                            ></i>
                                        </button>
                                    </div>
                                    <InputError
                                        :message="loginForm.errors.password"
                                        class="mt-2"
                                    />
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input
                                        v-model="loginForm.remember"
                                        type="checkbox"
                                        id="remember"
                                        class="h-4 w-4 rounded border border-gray-300 text-blue-600 focus:ring-blue-500"
                                    />
                                    <label
                                        for="remember"
                                        class="ml-1 block text-sm text-gray-900"
                                    >
                                        Keep me signed in
                                    </label>
                                </div>
                                <span class="text-sm text-blue-600 ml-auto">Reset Password</span>

                                <div class="text-sm">
                                    <Link
                                        
                                        class="font-semibold text-blue-600 hover:text-blue-500"
                                    >
                                        Forgot password?
                                    </Link>
                                </div>
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    :disabled="loginForm.processing"
                                    class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                                >
                                    {{
                                        loginForm.processing
                                            ? "Signing in..."
                                            : "Sign in"
                                    }}
                                </button>
                            </div>
                        </form>

                        <div class="mt-6">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div
                                        class="w-full border-t border-gray-300"
                                    ></div>
                                </div>
                                <div
                                    class="relative flex justify-center text-sm"
                                >
                                    <span class="bg-white px-2 text-gray-500"
                                        >Or continue with</span
                                    >
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <button
                                    type="button"
                                    @click="socialLogin('google')"
                                    class="flex w-full items-center justify-center gap-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                >
                                    <img
                                        :src="'/icons/icons8-google-48.png'"
                                        alt="Google logo"
                                        class="h-5 w-5"
                                    />
                                    <span>Google</span>
                                </button>

                                <button
                                    type="button"
                                    @click="socialLogin('linkedin')"
                                    class="flex w-full items-center justify-center gap-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                >
                                    <img
                                        :src="'/icons/icons8-linkedin-48.png'"
                                        alt="LinkedIn logo"
                                        class="h-5 w-5"
                                    />
                                    <span>LinkedIn</span>
                                </button>
                            </div>
                        </div>

                        <p class="mt-6 text-center text-sm text-gray-500">
                            Don't have an account?
                            <button
                                type="button"
                                @click="activeForm = 'register'"
                                class="font-semibold text-blue-600 hover:text-blue-500 ml-1"
                            >
                                Create account
                            </button>
                        </p>
                    </div>

                    <!-- Register Form -->
                    <div v-else class="w-full max-w-md">
                        <div class="text-center">
                            <h2
                                class="mt-2 text-3xl font-bold tracking-tight text-gray-900"
                            >
                                Create an account
                            </h2>
                            <p class="mb-4 mt-2 text-sm text-gray-600">
                                Provide your details to create an account
                            </p>
                        </div>

                        <form
                            @submit.prevent="submitRegister"
                            class="mt-2"
                        >
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                    <label
                                        for="first_name"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        First Name
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            v-model="registerForm.first_name"
                                            type="text"
                                            id="first_name"
                                            required
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                            placeholder="John"
                                        />
                                    </div>
                                    <InputError
                                        :message="
                                            registerForm.errors.first_name
                                        "
                                        class="mt-2"
                                    />
                                </div>

                                <div>
                                    <label
                                        for="last_name"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Last Name
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            v-model="registerForm.last_name"
                                            type="text"
                                            id="last_name"
                                            required
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                            placeholder="Doe"
                                        />
                                    </div>
                                    <InputError
                                        :message="registerForm.errors.last_name"
                                        class="mt-2"
                                    />
                                </div>
                                </div>
                                

                                <div>
                                    <label
                                        for="email"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Email Address
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            v-model="registerForm.email"
                                            type="email"
                                            id="email"
                                            required
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                            placeholder="johndoe@example.com"
                                        />
                                    </div>
                                    <InputError
                                        :message="registerForm.errors.email"
                                        class="mt-2"
                                    />
                                </div>

                                <div>
                                    <label
                                        for="password"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Password
                                    </label>
                                    <div class="relative mt-1">
                                        <input
                                            v-model="registerForm.password"
                                            :type="
                                                showPassword
                                                    ? 'text'
                                                    : 'password'
                                            "
                                            id="password"
                                            required
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                            placeholder="Enter password"
                                        />
                                        <button
                                            type="button"
                                            @click="
                                                showPassword = !showPassword
                                            "
                                            class="absolute inset-y-0 right-0 flex items-center pr-3"
                                        >
                                            <i
                                                :class="
                                                    showPassword
                                                        ? 'fas fa-eye-slash'
                                                        : 'fas fa-eye'
                                                "
                                                class="h-4 w-4 text-gray-800"
                                            ></i>
                                        </button>
                                    </div>
                                    <InputError
                                        :message="registerForm.errors.password"
                                        class="mt-2"
                                    />

                                    <!-- Password strength indicators -->
                                    <div
                                        v-if="registerForm.password"
                                        class="mt-2 space-y-2"
                                    >
                                        <div class="flex items-center gap-2">
                                            <div class="flex-shrink-0">
                                                <svg
                                                    v-if="hasUppercase"
                                                    class="w-4 h-4 text-green-500"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    />
                                                    <path
                                                        d="M8 12L11 15L16 9"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                                <svg
                                                    v-else
                                                    class="w-4 h-4 text-red-500"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    />
                                                    <path
                                                        d="M15 9L9 15M9 9L15 15"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-sm"
                                                :class="
                                                    hasUppercase
                                                        ? 'text-green-500'
                                                        : 'text-red-500'
                                                "
                                            >
                                                Uppercase letters
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-shrink-0">
                                                <svg
                                                    v-if="hasLowercase"
                                                    class="w-4 h-4 text-green-500"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    />
                                                    <path
                                                        d="M8 12L11 15L16 9"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                                <svg
                                                    v-else
                                                    class="w-4 h-4 text-red-500"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    />
                                                    <path
                                                        d="M15 9L9 15M9 9L15 15"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-sm"
                                                :class="
                                                    hasLowercase
                                                        ? 'text-green-500'
                                                        : 'text-red-500'
                                                "
                                            >
                                                Lowercase letters
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-shrink-0">
                                                <svg
                                                    v-if="hasNumber"
                                                    class="w-4 h-4 text-green-500"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    />
                                                    <path
                                                        d="M8 12L11 15L16 9"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                                <svg
                                                    v-else
                                                    class="w-4 h-4 text-red-500"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    />
                                                    <path
                                                        d="M15 9L9 15M9 9L15 15"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-sm"
                                                :class="
                                                    hasNumber
                                                        ? 'text-green-500'
                                                        : 'text-red-500'
                                                "
                                            >
                                                Numbers
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-shrink-0">
                                                <svg
                                                    v-if="hasSpecialChar"
                                                    class="w-4 h-4 text-green-500"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    />
                                                    <path
                                                        d="M8 12L11 15L16 9"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                                <svg
                                                    v-else
                                                    class="w-4 h-4 text-red-500"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    />
                                                    <path
                                                        d="M15 9L9 15M9 9L15 15"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-sm"
                                                :class="
                                                    hasSpecialChar
                                                        ? 'text-green-500'
                                                        : 'text-red-500'
                                                "
                                            >
                                                Special characters
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Confirm Password
                                    </label>
                                    <div class="mt-1">
                                        <input
                                            v-model="
                                                registerForm.password_confirmation
                                            "
                                            type="password"
                                            id="password_confirmation"
                                            required
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                            placeholder="Enter password again"
                                        />
                                    </div>
                                    <InputError
                                        :message="
                                            registerForm.errors
                                                .password_confirmation
                                        "
                                        class="mt-2"
                                    />
                                </div>

                                <div class="flex mb-4">
                                    <input
                                        v-model="registerForm.terms"
                                        type="checkbox"
                                        id="terms"
                                        required
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    />
                                    <label
                                        for="terms"
                                        class="ml-2 block text-sm text-gray-900"
                                    >
                                        I agree to the Terms of Service and
                                        Privacy Policy
                                    </label>
                                </div>
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    :disabled="registerForm.processing"
                                    class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                                >
                                    {{
                                        registerForm.processing
                                            ? "Creating account..."
                                            : "Create account"
                                    }}
                                </button>
                            </div>
                        </form>

                        <p class="mt-6 text-center text-sm text-gray-500">
                            Already have an account?
                            <button
                                type="button"
                                @click="activeForm = 'login'"
                                class="font-semibold text-blue-600 hover:text-blue-500 ml-1"
                            >
                                Sign in
                            </button>
                        </p>
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

.fade-enter-to,
.fade-leave-from {
    opacity: 1;
    transform: translateX(0);
}
/* Slide Transition */
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.4s ease-in-out, opacity 0.4s;
}
.slide-enter-from {
    transform: translateX(100%);
    opacity: 0;
}
.slide-leave-to {
    transform: translateX(-100%);
    opacity: 0;
}
</style>
