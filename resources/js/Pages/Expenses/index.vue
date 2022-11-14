<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ChevronRightIcon, ChevronLeftIcon } from '@heroicons/vue/24/solid'
import { Inertia } from '@inertiajs/inertia';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    expenses: {
        type: Object,
        default: () => ({})
    }
});

const destroy = (id) => {
    if(confirm('Confirmar ação:')) {
        Inertia.delete(route('expense.destroy', id))
    }
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Expenses
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="pb-6 grid grid-cols-4 align-middle content-end">
                    <Link :href="route('expense.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full text-center" type="button">Create</Link>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="table table-fixed hover:table-auto">
                            <div class="table-header-group">
                                <div class="table-row">
                                    <div class="table-cell py-4 px-6 text-left w-1/12">id</div>
                                    <div class="table-cell py-4 px-6 text-left w-4/12">description</div>
                                    <div class="table-cell py-4 px-6 text-left w-1/12">amount</div>
                                    <div class="table-cell py-4 px-6 text-left w-1/12">user</div>
                                    <div class="table-cell py-4 px-6 text-left w-1/12">date</div>
                                    <div class="table-cell py-4 px-6 text-left w-4/12">commands</div>
                                </div>
                            </div>
                            <div class="table-row-group">
                                <div class="table-row" v-for="expense in expenses.data" :key="expense.id">
                                    <div class="table-cell py-4 px-6">{{ expense.id }}</div>
                                    <div class="table-cell py-4 px-6">{{ expense.description }}</div>
                                    <div class="table-cell py-4 px-6">R${{ expense.amount }}</div>
                                    <div class="table-cell py-4 px-6">{{ expense.user.name }}</div>
                                    <div class="table-cell py-4 px-6">{{ expense.date }}</div>
                                    <div class="table-cell py-4 px-6 grid grid-cols-2 gap-2 align-middle content-between">
                                        <Link :href="route('expense.edit', expense.id)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full text-center" type="button">Editar</Link>
                                        <Link @click="destroy(expense.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-1 rounded-full text-center" type="button">Delete</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                        <div class="flex flex-1 justify-between sm:hidden">
                            <Link href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Anterior</Link>
                            <Link href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Próximo</Link>
                        </div>
                        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                Mostrando de
                                {{ ' ' }}
                                <span class="font-medium">{{expenses.meta.from}}</span>
                                {{ ' ' }}
                                até
                                {{ ' ' }}
                                <span class="font-medium">{{expenses.meta.to}}</span>
                                {{ ' ' }}
                                de
                                {{ ' ' }}
                                <span class="font-medium">{{expenses.meta.total}}</span>
                                {{ ' ' }}
                                resultados
                                </p>
                            </div>
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <Link :href="expenses.links.first" class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                                    <span class="sr-only">Primeiro</span>
                                    <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                                </Link>

                                <div v-for="(link, index) in expenses.meta.links">
                                    <Link
                                        :href="link.url"
                                        v-if="link.active"
                                        class="relative inline-flex items-center border px-4 py-2 text-sm font-medium border-indigo-500 bg-indigo-50 text-indigo-600 focus:z-20 z-10"
                                    >
                                        {{link.label}}
                                    </Link>
                                    <Link
                                        :href="link.url"
                                        v-else-if="link.url === expenses.links.prev || link.url === expenses.links.next"
                                        class="relative inline-flex items-center border px-4 py-2 text-sm font-medium border-gray-300 bg-white text-gray-500 hover:bg-gray-50 focus:z-20"
                                    >
                                        {{link.label}}
                                    </Link>
                                    <Link
                                        :href="link.url"
                                        v-else-if="link.label > expenses.meta.current_page - 3 && link.label < expenses.meta.current_page + 3"
                                        class="relative inline-flex items-center border px-4 py-2 text-sm font-medium border-gray-300 bg-white text-gray-500 hover:bg-gray-50 focus:z-20"
                                    >
                                        {{link.label}}
                                    </Link>
                                    <span
                                        v-else-if="link.label > expenses.meta.current_page - 4 && link.label < expenses.meta.current_page + 4"
                                        class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700"
                                    >...</span>
                                </div>

                                <Link :href="expenses.links.last" class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                                    <span class="sr-only">Último</span>
                                    <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                                </Link>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
