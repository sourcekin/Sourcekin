namespace Sourcekin\User\Model {
    data UserId   = UserId deriving (Uuid);
    data EMail    = String;
    data UserName = String;
    data Password = String;
}

namespace Sourcekin\Content\Model {
    data DocumentId = DocumentId deriving(Uuid);
    data DocumentName       = String deriving (FromString, ToString);
    data DocumentTitle      = String deriving (FromString, ToString);
    data DocumentText       = String deriving (FromString, ToString);

    data Key   = String deriving (FromString, ToString);
    data Value = String deriving( FromString, ToString);

    data DocumentMeta = DocumentMeta { Key $key, Value $value }
    deriving (FromArray, ToArray)
    where
        DocumentMeta:
            | strlen($key->toString()) === 0 => 'Empty meta key'
    ;
    data ContentId   = ContentId deriving (Uuid);
    data ContentName = String deriving (FromString, ToString);
    data ContentType = String deriving (FromString, ToString);
    data Index       = Index { int $index }
        deriving (FromScalar, ToScalar, Equals)
        where Index:
            | $index < 0 => 'Only positive integers are allowed';

    data ValueType = Text | Image | Video | Link | Reference deriving (Enum);
    data Field   = Field { Key $key, Value $value, ValueType $type, Index $index } deriving (FromArray, ToArray, Equals);


}