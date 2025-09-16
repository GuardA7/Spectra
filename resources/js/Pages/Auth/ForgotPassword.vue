<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-indigo-100 p-4">
    <div class="flex flex-col w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">

      <!-- Header -->
      <div class="bg-gradient-to-r from-green-600 to-indigo-700 text-white p-8 text-center">
        <h2 class="text-2xl font-bold mb-2">Lupa Kata Sandi</h2>
        <p class="text-sm opacity-90">Masukkan email Anda untuk menerima link reset password</p>
      </div>

      <!-- Form -->
      <div class="p-6">
        <form @submit.prevent="submit" class="space-y-4">
          <!-- Email -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input 
              type="email"
              v-model="form.email"
              placeholder="Masukkan email"
              class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
            />
            <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
          </div>

          <!-- Submit -->
          <button 
            type="submit"
            :disabled="isLoading"
            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ isLoading ? 'Memproses...' : 'Kirim Link Reset Password' }}
          </button>
        </form>

        <!-- Link kembali ke login -->
        <div class="text-center mt-4">
          <Link href="/login" class="text-green-600 hover:underline text-sm">
            Kembali ke login
          </Link>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/vue3'

const form = reactive({
  email: ''
})

const errors = reactive({})
const isLoading = ref(false)

const submit = () => {
  // Reset errors
  Object.keys(errors).forEach(key => delete errors[key])

  // Validasi client-side
  if (!form.email) {
    errors.email = 'Email wajib diisi'
    return
  }

  isLoading.value = true

  Inertia.post('/forgot-password', form, {
    onFinish: () => isLoading.value = false,
    onError: (serverErrors) => {
      if (serverErrors && serverErrors.errors) Object.assign(errors, serverErrors.errors)
    }
  })
}
</script>
