# php-RoaringBitmap

不想写备注 

----

### 插入 add(int)

### 删除 del(int)

### 查找 find(int):bool

### runOptimize() 

    只有调用此函数的时候内部的container才会进行优化，否则的话默认都是数组容器。优化会根据占用内存大小进行容器类型选择。

### 获取 get():array

    通过此获得一个数组，将这个数组格式保存到硬盘获得内存中，下次使用的时候时候 set(array) 进行复原

### 复原 set(array)

    通过此函数设置roaringbitmap，然后能够继续对上次保存的结果进行操作

### 获取所有 getInts():array

    得到所有的数字
