<template>
  <div>
    <div>
      <div class="content">
        <div class="container-fluid">
          <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
          <div
            class="
              _1adminOverveiw_table_recent
              _box_shadow
              _border_radious
              _mar_b30
              _p20
            "
          >
            <p class="_title0">
              Categories
              <Button @click="addModal = true" class="add-category"
                ><Icon type="md-add" />Add New Category</Button
              >
            </p>

            <div class="_overflow _table_div">
              <table class="_table">
                <!-- TABLE TITLE -->
                <tr>
                  <th colspan="2" class="category-name">Name</th>
                  <!-- <th>Nom du morceau</th>
                  <th>Ajouté le</th> -->
                  <th>Action</th>
                </tr>
                <!-- TABLE TITLE -->

                <!-- ITEMS -->
                <tr v-for="(category, i) in categories" :key="i">
                  <!-- <td>{{ tag.id }}</td> -->
                  <td
                    colspan="2"
                    @click="toSubCategory(category)"
                    style="cursor: pointer"
                  >
                    {{ category.categoryName }}
                  </td>
                  <!-- <td>{{ tag.created_at | moment("DD-MM-YYYY [à] hh:mm") }}</td> -->
                  <td>
                    <Button
                      type="info"
                      size="small"
                      @click="showEditModal(category, i)"
                      class="update-category"
                      >Update</Button
                    >
                    <Button
                      type="error"
                      size="small"
                      @click="showDeletingModal(category, i)"
                      :loading="category.isDeleting"
                      class="delete-category"
                      >Delete</Button
                    >
                  </td>
                </tr>
                <!-- ITEMS -->
              </table>
            </div>
          </div>
          <!-- Tag adding modal -->
          <Modal
            v-model="addModal"
            title="Add New Category"
            :mask-closable="false"
            :closable="false"
          >
            <div style="display: flex; align-items: center">
              <label
                for="category-name"
                style="font-weight: bold; margin-right: 5px; margin-bottom: 0px"
                >Name:</label
              >
              <Input
                id="category-name"
                v-model="data.categoryName"
                placeholder="Please input Category's name"
              />
            </div>

            <div slot="footer">
              <Button type="default" @click="addModal = false">Cancel</Button>
              <Button
                type="primary"
                @click="addCategory"
                :disabled="isAdding"
                :loading="isAdding"
                >{{ isAdding ? "Adding.." : "Add" }}</Button
              >
            </div>
          </Modal>
          <!-- Tag editing modal -->
          <Modal
            v-model="editModal"
            title="Update Category"
            :mask-closable="false"
            :closable="false"
          >
            <div style="display: flex; align-items: center">
              <label
                for="category-name-update"
                style="font-weight: bold; margin-right: 5px; margin-bottom: 0px"
                >Name:</label
              >
              <Input
                id="category-name-update"
                v-model="editData.categoryName"
                placeholder="Please input Category's name"
              />
            </div>

            <div slot="footer">
              <Button type="default" @click="editModal = false">Cancel</Button>
              <Button
                type="primary"
                @click="editCategory"
                :disabled="isAdding"
                :loading="isAdding"
                >{{ isAdding ? "Updating.." : "Update" }}</Button
              >
            </div>
          </Modal>
          <!-- Tag deleting modal confirmation -->
          <Modal v-model="showDeleteModal" width="360">
            <p slot="header" style="color: #f60; text-align: center">
              <Icon type="ios-information-circle"></Icon>
              <span>Delete Confirmation</span>
            </p>
            <div style="text-align: center">
              <p>Are you sure you want to delete this Category?</p>
            </div>
            <div slot="footer">
              <Button
                type="error"
                size="large"
                long
                :loading="isDeleting"
                :disabled="isDeleting"
                @click="deleteCategory"
                >OK</Button
              >
            </div>
          </Modal>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        categoryName: "",
      },
      addModal: false,
      editModal: false,
      isAdding: false,
      categories: [],
      editData: {
        categoryName: "",
      },
      index: -1,
      showDeleteModal: false,
      isDeleting: false,
      deleteItem: {},
      deletingIndex: -1,
    };
  },

  methods: {
    async addCategory() {
      if (this.data.categoryName.trim() == "") return this.e("Required Field");
      const res = await this.callApi("post", "app/create_category", this.data);
      console.log("added res status => ", res);
      if (res.status == 201) {
        this.categories.unshift(res.data);
        this.s("A New Category is added successfully!");
        this.addModal = false;
        this.data.categoryName = "";
      } else {
        if (res.status == 422) {
          if (res.data.errors.categoryName) {
            this.e(res.data.errors.categoryName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    async editCategory() {
      if (this.editData.categoryName.trim() == "")
        return this.e("Champs requis");
      const res = await this.callApi(
        "post",
        "app/edit_category",
        this.editData
      );
      if (res.status == 200) {
        this.categories[this.index].categoryName = this.editData.categoryName;
        this.s("The Category has been updated!");
        this.editModal = false;
      } else {
        if (res.status == 422) {
          if (res.data.errors.categoryName) {
            this.e(res.data.errors.categoryName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    showEditModal(category, index) {
      let obj = {
        id: category.id,
        categoryName: category.categoryName,
      };
      this.editData = obj;
      this.editModal = true;
      this.index = index;
    },
    async deleteCategory() {
      this.isDeleting = true;
      const res_item = await this.callApi(
        "post",
        "/items/delete_item_category",
        {
          categoryId: this.deleteItem.id,
        }
      );
      if (res_item) {
        const res_sub = await this.callApi(
          "post",
          "/SubCategories/delete_sub_category",
          {
            categoryId: this.deleteItem.id,
          }
        );
        if (res_sub) {
          const res = await this.callApi(
            "post",
            "app/delete_category",
            this.deleteItem
          );
          if (res.status == 200) {
            this.categories.splice(this.deletingIndex, 1);
            this.s("The Category has been deleted!");
          } else {
            this.swr();
          }
          this.isDeleting = false;
          this.showDeleteModal = false;
        }
      }
    },
    showDeletingModal(category, i) {
      this.deleteItem = category;
      this.deletingIndex = i;
      this.showDeleteModal = true;
    },
    toSubCategory(categoryInfo) {
      this.$router.push({
        name: "SubCategory",
        params: { categoryId: categoryInfo.id },
      });
    },
  },

  async created() {
    const res = await this.callApi("get", "app/get_categories");
    if (res.status == 200) {
      this.categories = res.data;
      console.log("Categories => ", this.categories);
    } else {
      this.swr();
    }
  },
};
</script>

<style scoped>
.add-category {
  float: right;
}
.category-name {
  width: 80%;
}
.update-category {
  margin-bottom: 5px;
  width: 90px;
}
.delete-category {
  margin-bottom: 5px;
  width: 90px;
}
</style>