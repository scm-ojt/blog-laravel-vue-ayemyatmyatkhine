import { ref, Ref } from "@vue/reactivity";
import axios from "axios";

import { usePagination } from "~/composable/useClientSidePagination";

export interface Todo {
  id: number;
  name: string;
}

export function useTodosApi(
  currentPage: Ref<number>,
  rowsPerPage?: Ref<number>
) {
  const todos: Ref<Todo[]> = ref([]);

  const { paginatedArray, numberOfPages } = usePagination<Todo>({
    rowsPerPage,
    arrayToPaginate: todos,
    currentPage
  });

  const loadTodos = async () => {
    try {
      await axios.get('http://127.0.0.1:8000/api/category/list').then((response)=>{
        todos.value = response.data.data
      });
    } catch (err) {
      console.log(err);
    } 
  };
  return {
    todos: paginatedArray,
    numberOfPages
  };
}
