<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

import { Head, Link, useForm } from '@inertiajs/inertia-vue3';


const props = defineProps({
    user: {
        type: Object,
        default: () => ({})
    }
});



const form = useForm({
    'description': '',
    'amount': '',
    'date': '',
    'user_id': props.user.id
});


const submit = () => {
    form.post(route('expense.store'), {
        // onFinish: () => form.reset('description'),
    });
};


</script>

<template>
    <AuthenticatedLayout>
        <Head title="New Expense" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Expense
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-4 py-6">
                    <form @submit.prevent="submit">

                        <div class="mt-4">
                            <InputLabel for="description" value="Description" />
                            <TextArea id="description" type="text" class="mt-1 block w-full" v-model="form.description" required autofocus autocomplete="description" />
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="amount" value="Amount" />
                            <TextInput id="amount" type="text" class="mt-1 block w-full" v-model="form.amount" required autofocus autocomplete="amount" />
                            <InputError class="mt-2" :message="form.errors.amount" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="date" value="Date" />
                            <div class='input-group date' id='datetimepicker'>
                            <Datepicker v-model="form.date"></Datepicker>
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </AuthenticatedLayout>
</template>
